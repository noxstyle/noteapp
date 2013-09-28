<div class="note-holder">

    <div id="empty-notepad" data-bind="visible: filteredNotes().length <= 0">

        <div class="smiley">
            <span class="left-eye"></span>
            <span class="right-eye"></span>
            <span class="mouth"></span>
        </div><!-- /.no-active-notes -->
        
        <h2>No active notes</h2>
        <p>Start by creating a new one or opening existing note...</p>
    </div><!-- /#empty-notepad -->

    <ul id="notes" data-bind="foreach: filteredNotes" class="clearfix">
        <li class="note note-list">

            <div class="note-heading">
                <h3>
                    <div class="pull-right">
                        <a href="#" class="action-block" data-bind="click: $parent.toggleNoteVisiblity">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                        </a>
                        <a href="#" class="action-block" data-bind="click: $parent.closeNote">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                        </a>
                    </div>

                    <input type="text" name="title" placeholder="Untitled" data-bind="value: title"></input>
                </h3>
            </div><!-- /.note-heading -->

            <div class="note-content">

                <div class="textarea-holder">
                    <textarea placeholder="Untitled" name="content" data-bind="value: content"></textarea>
                </div><!-- /.textarea-holder -->

                <input type="text" class="add-tags" data-bind="value: tags, select2: $root.getTagListAsArray()" placeholder="Tags">
                <div class="note-footer">
                    <span data-bind="text: lastModified"></span>

                    <div class="btn-group dropup pull-right">
                        <a class="dropdown-toggle actions" data-toggle="dropdown">
                            <span href="#" class="glyphicon glyphicon-cog"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-bind="click: $parent.deleteNote"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a></li>
                        </ul><!-- /.dropdown-menu -->
                    </div>
                </div><!-- /.note-footer -->
            </div><!-- /.note-content -->

        </li>
    </ul>
</div>