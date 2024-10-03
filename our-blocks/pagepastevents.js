wp.blocks.registerBlockType("ourblocktheme/pagepastevents", {
    title: "Page past Events Fictional University Block Theme",
    edit: function() {
        return wp.element.createElement("div", {className: "our-placeholder-block"}, "Page Past Events Placeholder")
    },
    save: function() {
        return null
    }
})