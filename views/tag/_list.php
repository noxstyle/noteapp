<ul id="tags" data-bind="foreach: {data: tags, as: 'tag'}">
    <?php // visible: $root.getNotesByTag(tag).length > 0 ?>
    <li data-bind="css: { 'active': active() }">
        <a href="#" data-bind="click: $parent.showNotesForTag">
            <span data-bind="text: name"></span>
            <strong data-bind="text: $root.getNotesByTag(tag).length"></strong>
        </a>
        <ul data-bind="foreach: {data: $root.getNotesByTag(tag), as: 'note'}, style: { display: active() ? 'block' : 'none'}">
            <li>
                <a href="#" data-bind="disableClick: note.active(), click: $root.openNote, text: note.title, css: {active: note.active()}"></a>
            </li>
        </ul>
    </li>
</ul>