wp.blocks.registerBlockType("ourblocktheme/singleprofessor", {
    title: "Single Professor Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Single Professor Placeholder")
    },
    save: function() {
        return null
    }
})