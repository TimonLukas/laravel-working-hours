const parser = document.createElement('a');
parser.href = location.href;

const dataIfs = ["underline", "active"];

dataIfs.forEach(dataIf => {
    const selector = `data-${dataIf}-if`;
    const elements = document.querySelectorAll(`[${selector}]`);
    elements.forEach(element => {
        const ifUrl = element.attributes[selector].value;
        if (parser.pathname.indexOf(ifUrl) !== -1) {
            element.className = dataIf;
        }
    });
});