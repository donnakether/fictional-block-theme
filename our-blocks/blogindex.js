wp.blocks.registerBlockType("ourblocktheme/blogindex", {
    title: "Blog Index Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Blog Index Placeholder")
    },
    save: function() {
        return null
    }
})