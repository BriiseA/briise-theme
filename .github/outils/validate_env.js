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
