wp.blocks.registerBlockType("ourblocktheme/campusarchive", {
    title: "Campus Archive Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Campus Archive Placeholder")
    },
    save: function() {
        return null
    }
})