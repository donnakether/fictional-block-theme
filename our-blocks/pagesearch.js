wp.blocks.registerBlockType("ourblocktheme/pagesearch", {
    title: "Page Search Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Page Search Placeholder")
    },
    save: function() {
        return null
    }
})