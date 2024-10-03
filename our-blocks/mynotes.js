wp.blocks.registerBlockType("ourblocktheme/mynotes", {
    title: "My Notes Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "My Notes Placeholder")
    },
    save: function() {
        return null
    }
})