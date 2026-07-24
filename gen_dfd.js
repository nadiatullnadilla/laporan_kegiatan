const fs = require('fs');
const https = require('https');
const zlib = require('zlib');

function encode64(data) {
    let r = "";
    for (let i = 0; i < data.length; i += 3) {
        if (i + 2 === data.length) {
            r += append3bytes(data[i], data[i + 1], 0);
        } else if (i + 1 === data.length) {
            r += append3bytes(data[i], 0, 0);
        } else {
            r += append3bytes(data[i], data[i + 1], data[i + 2]);
        }
    }
    return r;
}

function append3bytes(b1, b2, b3) {
    const c1 = b1 >> 2;
    const c2 = ((b1 & 0x3) << 4) | (b2 >> 4);
    const c3 = ((b2 & 0xF) << 2) | (b3 >> 6);
    const c4 = b3 & 0x3F;
    let r = "";
    r += encode6bit(c1 & 0x3F);
    r += encode6bit(c2 & 0x3F);
    r += encode6bit(c3 & 0x3F);
    r += encode6bit(c4 & 0x3F);
    return r;
}

function encode6bit(b) {
    if (b < 10) return String.fromCharCode(48 + b);
    b -= 10;
    if (b < 26) return String.fromCharCode(65 + b);
    b -= 26;
    if (b < 26) return String.fromCharCode(97 + b);
    b -= 26;
    if (b === 0) return '-';
    if (b === 1) return '_';
    return '?';
}

function generateImage(inputFile, outputFile) {
    const puml = fs.readFileSync(inputFile, 'utf8');
    const deflated = zlib.deflateSync(puml, { level: 9 });
    const encoded = encode64(deflated);
    const url = 'https://www.plantuml.com/plantuml/png/~1' + encoded;

    console.log("Fetching URL: " + url);

    https.get(url, (res) => {
        if (res.statusCode !== 200) {
            console.error(`Request Failed. Status Code: ${res.statusCode}`);
            res.resume();
            return;
        }
        const file = fs.createWriteStream(outputFile);
        res.pipe(file);
        file.on('finish', () => {
            file.close();
            console.log('Image downloaded successfully to ' + outputFile);
        });
    }).on('error', (err) => {
        console.error('Error:', err.message);
    });
}

generateImage('dfd_level0.puml', 'dfd_level0.png');
generateImage('dfd_level1.puml', 'dfd_level1.png');
