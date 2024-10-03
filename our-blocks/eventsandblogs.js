wp.blocks.registerBlockType("ourblocktheme/eventsandblogs", {
    title: "Events and Blogs",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Events and Blog Placeholder")
    },
    save: function() {
        return null
    }
})