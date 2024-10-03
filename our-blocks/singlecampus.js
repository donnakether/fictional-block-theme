wp.blocks.registerBlockType("ourblocktheme/singlecampus", {
    title: "Single Campus Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Single Campus Placeholder")
    },
    save: function() {
        return null
    }
})