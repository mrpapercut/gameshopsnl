'use strict';

import React, {
	DOM,
	createElement,
	createFactory,
	PropTypes as PT
} from 'react';

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

const Resultgroup = ({shop, results}) => div({
	className: 'resultgroup',
	key: rand()
},
	div({
		className: 'resultheader'
	}, shop),
	results.map(result)
);

Resultgroup.propTypes = {
	shop: PT.string.isRequired,
	results: PT.array.isRequired
};

export default Resultgroup;