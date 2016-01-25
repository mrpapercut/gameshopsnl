'use strict';

import HTMLparser from 'htmlparser';

import shopHandlers from './shopHandlers';

export const parseHTML = (html, shop, key) => {
	const Handler = new HTMLparser.DefaultHandler(err => err ? console.warn(err) : null);
	const Parser = new HTMLparser.Parser(Handler);
	Parser.parseComplete(html);

	return shopHandlers[shop](Handler.dom);
}

export const _getHTML = dom => dom.filter(el => el.type === 'tag' && el.name === 'html')[0];

export const _getBody = dom =>
	_cleanElements(_getHTML(dom).children.filter(el => el.type === 'tag' && el.name === 'body')[0]);

export const _cleanElements = dom =>
	dom.children.filter(el => ['comment', 'directive'].indexOf(el.type) === -1).filter(el => !el.data.match(/^\s*$/));