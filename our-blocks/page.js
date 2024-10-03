wp.blocks.registerBlockType("ourblocktheme/page", {
    title: "Page Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Page Placeholder")
    },
    save: function() {
        return null
    }
})