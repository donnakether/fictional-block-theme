wp.blocks.registerBlockType("ourblocktheme/singleevent", {
    title: "Single Event Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Single Event Post Placeholder")
    },
    save: function() {
        return null
    }
})