const plantumlEncoder = require('plantuml-encoder');
const fs = require('fs');
const https = require('https');

const puml = fs.readFileSync('usecase_plantuml.puml', 'utf8');
const encoded = plantumlEncoder.encode(puml);
const url = 'https://www.plantuml.com/plantuml/png/' + encoded;

https.get(url, (res) => {
  if (res.statusCode !== 200) {
    console.error(`Request Failed. Status Code: ${res.statusCode}`);
    res.resume();
    return;
  }
  const file = fs.createWriteStream('usecase_plantuml.png');
  res.pipe(file);
  file.on('finish', () => {
    file.close();
    console.log('Image downloaded successfully to usecase_plantuml.png');
  });
}).on('error', (err) => {
  console.error('Error:', err.message);
});
