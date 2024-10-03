wp.blocks.registerBlockType("ourblocktheme/eventarchive", {
    title: "Event Archive Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Event Archive Placeholder")
    },
    save: function() {
        return null
    }
})