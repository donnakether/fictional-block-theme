wp.blocks.registerBlockType("ourblocktheme/eventsandblogs", {
    title: "Events and Blogs",
    supports: {
        align: ["full"]
    },
    edit: function() {
        return wp.element.createElement("div", null, "This is a Placeholder")
    },
    save: function() {
        return null
    }
})