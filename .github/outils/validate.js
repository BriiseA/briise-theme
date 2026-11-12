const { JSDOM } = require('jsdom');
const dom = new JSDOM('<!doctype html><html><body></body></html>', { url: 'http://localhost/' });
for (const k of ['window','document','navigator','Node','HTMLElement','Element','DOMParser','MutationObserver','getComputedStyle','CustomEvent','Event','KeyboardEvent','requestAnimationFrame','localStorage','matchMedia']) {
  if (!(k in global)) { try { global[k] = dom.window[k]; } catch(e){} }
}
global.window.matchMedia = global.window.matchMedia || (() => ({ matches:false, addListener(){}, removeListener(){}, addEventListener(){}, removeEventListener(){} }));
global.matchMedia = global.window.matchMedia;
global.requestAnimationFrame = global.requestAnimationFrame || (cb => setTimeout(cb, 0));
global.ResizeObserver = global.ResizeObserver || class { observe(){} unobserve(){} disconnect(){} };
global.IntersectionObserver = global.IntersectionObserver || class { observe(){} unobserve(){} disconnect(){} };
const blocks = require('@wordpress/blocks');
const lib = require('@wordpress/block-library');
lib.registerCoreBlocks();
const data = JSON.parse(require('fs').readFileSync(process.argv[2], 'utf8'));
const img = s => s.replace('{{IMG1}}', 'http://localhost/a.svg').replace('{{IMG2}}', 'http://localhost/b.svg');
let bad = 0;
function walk(list, path) {
  for (const b of list) {
    if (!b.isValid) { bad++; console.log('INVALID', path + '/' + b.name); (b.validationIssues||[]).slice(0,3).forEach(i => console.log('   ', JSON.stringify(i.args).slice(0,400))); }
    walk(b.innerBlocks || [], path + '/' + b.name);
  }
}
const all = Object.assign({}, data.sections, { home: data.home });
for (const [k, m] of Object.entries(all)) { const parsed = blocks.parse(img(m)); walk(parsed, k); console.log(k, 'blocks:', parsed.length); }
console.log('WP packages:', require('@wordpress/blocks/package.json').version, '| invalid blocks:', bad);
