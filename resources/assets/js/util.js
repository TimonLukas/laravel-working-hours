const currentUrl = location.href;

const underlineIf = document.querySelectorAll("[data-underline-if]");
underlineIf.forEach(node => {
    const underlineIfUrl = node.attributes["data-underline-if"].value;
    if(currentUrl.indexOf(underlineIfUrl) !== -1) {
        node.className = "underline";
    }
});