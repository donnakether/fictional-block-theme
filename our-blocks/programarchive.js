wp.blocks.registerBlockType("ourblocktheme/programarchive", {
    title: "Program Archive Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Program Archive Placeholder")
    },
    save: function() {
        return null
    }
})