'use strict';

import React, {
	DOM,
	createClass,
	createFactory,
	PropTypes as PT
} from 'react';

import {parseHTML} from '../util/parseHTML';

const {div, a} = DOM;

const rand = () => btoa(+new Date / Math.random()).substr(6, 6);

const Result = ({image, platform, price, title, url}) => div({
	className: 'result',
	key: rand()
},
	a({
		href: url
	}, [platform, title, price].join(', '))
);

const result = createFactory(Result);

const Resultgroup = ({shop, results}) => {
	console.log(parseHTML(results, shop));
	return div({
		className: 'resultgroup',
		key: rand()
	},
		div({
			className: 'resultheader'
		}, shop)
		//parseHTML(results, shop).map(result)
	);
}

Resultgroup.propTypes = {
	shop: PT.string.isRequired,
	//results: PT.array.isRequired
};

export default Resultgroup;