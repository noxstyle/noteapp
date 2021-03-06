/*global ko Router */
(function ($) {
    "use strict";

    /* config
     * ======================= */
    $.config = {
        slideDuration: 250,
        untaggedName: 'Untagged' // The name for 'Untagged' entries
    };  

    /* Bindings
     * ======================= */

    // Select2 Bindings
    ko.bindingHandlers.select2 = {
        init: function(element, valueAccessor, allBindingsAccessor) {
            $(element).select2({
                tags: ko.toJS(valueAccessor()),
                tokenSeparators: [","]
            });

            ko.utils.domNodeDisposal.addDisposeCallback(element, function() {
                $(element).select2('destroy');
            });
        },
        update: function(element) {
            $(element).trigger('change');
        }
    };

    // Disable click binding
    ko.bindingHandlers.disableClick = {
        init: function (element, valueAccessor) {

            $(element).click(function(evt) {
                if(valueAccessor()) {
                    evt.preventDefault();
                    evt.stopImmediatePropagation();
                }
            });

        },

        update: function(element, valueAccessor) {
            var value = ko.utils.unwrapObservable(valueAccessor());
            ko.bindingHandlers.css.update(element, function() {return { disabled_anchor: value }; });
        }
    };

    /* Tag Model
     * ======================= */
    var Tag = function(data) {
        var self = this;
        self.id = data.id;
        self.name = data.name;
        self.active = ko.observable( data.active == 1 ? true : false );
    };

    /* Note Model
     * ======================= */
    var Note = function(data, vm) {
        var self = this;

        self.activeTimeout = null;

        self.id = data.id;
        self.title = ko.observable(data.title);
        self.content = ko.observable(data.content);

        self.insertTime = data.insert_time;
        self.updateTime = data.update_time;

        self.visible = true;
        self.active = ko.observable( (data.active == 1) ? true : false );

        self.tags = ko.observable(data.tags);

        // Subscribe for "tags" change in order to process the data
        self.tags.subscribe(function(){
            vm.updateTags(self.tags().split(","));
        });

        self.lastModified = ko.computed(function() {
            var lastModified = (!self.updateTime) ? self.insertTime : self.updateTime;
            return (!lastModified) ? 'New note...' : lastModified;
        });

        self.getTitle = ko.computed(function() {
            return (!self.title) ? 'Untitled...' : self.title;
        });
    };

    var ViewModel = function(notes, tags) {
        var self = this;

        // Notes
        self.notes = ko.observableArray(ko.utils.arrayMap(notes, function (note) {
            return new Note(note, self);
        }));

        // Tags
        self.tags = ko.observableArray(ko.utils.arrayMap(tags, function(tag) {
            return new Tag(tag);
        }));

        // Add empty tag
        self.tags.splice(0,0, new Tag({id:0, name:$.config.untaggedName}));

        // Filtered notes - i.e. active notes
        self.filteredNotes = ko.computed(function(){
            return ko.utils.arrayFilter(self.notes(), function(note){
                return note.active();
            });
        });

        // Helper method to pass tags as array to select2
        self.getTagListAsArray = function() {
            var tags = [];
            $.each(ko.toJS(self.tags), function(i,v){
                tags.push(v.name);
            });
            return tags;
        };

        /* Visual
         * ======================= */

        // Expands / Collapses given note
        self.toggleNoteVisiblity = function(note,event) {
            if (note.visible) {
                $(event.target)
                    .addClass('glyphicon-chevron-down')
                    .removeClass('glyphicon-chevron-up')
                    .parents('.note-heading')
                    .next()
                    .hide();
                note.visible = false;
            } else {
                $(event.target)
                    .addClass('glyphicon-chevron-up')
                    .removeClass('glyphicon-chevron-down')
                    .parents('.note-heading')
                    .next()
                    .slideDown();
                note.visible = true;
            }
        };

        // Toggles tag list display
        self.showNotesForTag = function(tag, event) {
            var clickedTag = $(event.target).get(0).tagName;
            if (clickedTag === 'A') {
                var parent = $(event.target).parent();
            } else {
                var parent = $(event.target).parent().parent();
            }

            var ul = parent.find('ul');
            if ($(ul).is(':visible')) {
                parent.removeClass('active');
                tag.active(false);
                ul.slideUp($.config.slideDuration);
            } else {
                parent.addClass('active');
                tag.active(true);
                ul.slideDown($.config.slideDuration);
            }
        };

        // Shows system status message on bottom bar
        self.showStatus = function(text, error) {
            var el = $('#status');

            if (self.activeTimeout)
                clearTimeout(self.activeTimeout);

            el.addClass('active')
                .find('p')
                .removeClass('error') // In case previous errors were present
                .html(text);

            // Set error class
            if (error)
                el.find('p').addClass('error');

            self.activeTimeout = setTimeout(function(){ $('#status').toggleClass('active'); }, 2000);
        };

        // Reinits niceScroll plugin to textareas found in .note-holder
        self.reinitNiceSroll = function() {
            $.each($('.note-holder textarea'), function(i,v){
                if ($(v).getNiceScroll().length == 0)
                    $(v).niceScroll();
            });
        };


        /* Operations
         * ======================= */

        // Updates tags if new tags found from "tags" array
        self.updateTags = function(tags) {
            ko.utils.arrayForEach(tags, function(newTag) {
                if (newTag != "") {

                    var isPresent = ko.utils.arrayFirst(self.tags(), function(tag) {
                        return tag.name == newTag;
                    });

                    if (!isPresent) {
                        var newObj = new Tag({id: 0, name: newTag});
                        self.tags.push(newObj);
                    }
                }
            });
        };

        self.getNotesByTag = function(tag) {
            var filter  = tag.name.toLowerCase();

            if (filter.length > 0) {
                var notesArray = self.notes();
                return ko.utils.arrayFilter(notesArray, function(note){
                    // Entries with actual tags
                    if (note.tags() && note.tags().length > 0) {
                        var curTags = note.tags().toLowerCase().split(',');
                        return curTags.indexOf(filter) !== -1;
                    } else {
                        // If accessing untagged.. return all empty values
                        if (filter === $.config.untaggedName.toLowerCase())
                            return true;
                    }
                });
            }
            return [];
        };

        self.closeNote = function(note, e) {
            note.active(false);
        };

        self.openNote = function(note, e) {
            note.active(true);

            // Reinit niceScroll if note present
            self.reinitNiceSroll();
        };

        self.addNote = function() {
            // Push with default values
            var note = new Note({id:-1, title:"", content:"", insert_time:null, update_time:null, tags: "", active:true}, self);
            self.notes.splice(0,0,note);

            // Reinit niceScroll if note present
            self.reinitNiceSroll();

            self.showStatus('New note created...');
        };

        self.deleteNote = function(note) {
            $.ajax({
                type: 'POST',
                dataType:'json',
                data: {note: ko.toJSON({id: note.id})},
                url: '?r=note/delete-note',
                success:function(d){
                    if (d.deleted) {
                        self.notes.remove(note);
                        self.showStatus('Note deleted...');
                    } else
                        self.showStatus('ERROR! Unable to delete note!', 1);
                },
                error: function(e) {
                    self.showStatus('ERROR! Unable to delete note!', 1);
                }
            });
        };

        self.saveNote = function() {
            var notes = ko.toJSON(self.notes);
            $.ajax({
                type: 'POST',
                dataType:'json',
                data: {notes: notes, tags: ko.toJSON(self.tags)},
                url: '?r=note/save-notes',
                success:function(d){
                    var mappedNotes = $.map(d.notes, function(item) {
                        return new Note(item, self);
                    });

                    var mappedTags = $.map(d.tags, function(item){
                        return new Tag(item);
                    });

                    self.notes(mappedNotes);
                    self.tags(mappedTags);

                    self.showStatus('Persistent storage updated...');
                },
                error: function(d) {
                    self.showStatus('ERROR while updating persistent storage!', 1);
                }
            });
        };

        self.initSelect2 = function() {
            jQuery('.add-tags').select2({
                tags: self.getTagListAsArray(),
                tokenSeparators: [","]
            });
        };

        /* Subscriptions
         * ================== */

        // Save a localStorage copy of notes on change
        ko.computed(function () {
            // Save notes
            localStorage.setItem('na-demo-notes', ko.toJSON(self.notes));

            // Remove the "Untagged" entry from tag list while saving to localStorage
            var saveableTags = ko.utils.arrayMap(self.tags(), function(tag) {
                if (tag.name != $.config.untaggedName)
                    return new Tag(tag);
            });
            saveableTags = saveableTags.filter(function(n){return n;});

            // Set the Tags storage item
            localStorage.setItem('na-demo-tags', ko.toJSON(saveableTags));
        }).extend({
            throttle: 500
        }); // save at most twice per second

    };

    // Load data stored in local storage
    var tags    = ko.utils.parseJson(localStorage.getItem('ko-tags'));
    var notes   = ko.utils.parseJson(localStorage.getItem('ko-notes'));

    // Load persistent data if local storage not found
    if (!tags || !notes) {
        $.ajax({
            dataType:'json',
            url: "?r=note/get-notes",
            async:false,
            success:function(d) {            
                tags = d.tags;
                notes = d.notes;
            }
        });
    };

    var vm = new ViewModel(notes || [], tags || []);
    ko.applyBindings( vm );

    /* Initialize niceScroll Baby!
     * ============================= */
    $('textarea').niceScroll();

    /* Navbar minification on scroll
     * ============================= */
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('#header').addClass('small');
        } else {
            $('#header').removeClass('small');
        }
    });

    /* Autoscroll to note on small devices
     * =================================== */

    // Set the initial state for autoscroll
    $(window).load(function(){
        $.autoScrollBindEl = $('ul#tags > li > ul > li > a');
        if ($(window).width() < 1000)
            $($.autoScrollBindEl).autoScrollToNote('enabled');
        
        // Window resize event
        $(window).resize(function () {
            if ($(window).width() < 1000) {
                // Enable autoScroll
                if (!$.autoScrollEnabled)
                    $($.autoScrollBindEl).autoScrollToNote('enabled');
            } else {
                // Disable autoScroll
                if ($.autoScrollEnabled)
                    $($.autoScrollBindEl).autoScrollToNote('disabled');
            }
        });
    });

    // Namespaces the autoscroll click event to allow unbiding of the event
    $.fn.autoScrollToNote = function( status ) {
        $.autoScrollEnabled = null;

        if (status == 'enabled') {    
            this.on( 'click.autoScrollToNote', function() {
                $('html, body').animate({
                    scrollTop: $('div.note-holder').offset().top - 80 // height of the fixed topbar + some padding
                });
            });
            $.autoScrollEnabled = true;
        } else {
            $(this).off('click.autoScrollToNote');
            $.autoScrollEnabled = false;
        }    
    };

})(jQuery);