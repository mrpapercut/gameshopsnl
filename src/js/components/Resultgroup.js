'use strict';

import React, {
	DOM,
	createClass,
	createFactory,
	PropTypes as PT
} from 'react';

import {parseHTML} from '../util/parseHTML';

const {div, a} = DOM;

const Result = ({image, platform, price, title, url}) => div({
	className: 'result'
},
	a({
		href: url
	}, [platform, title, price].join(', '))
);

const result = createFactory(Result);

const Resultgroup = ({shop, results}) => div({
	className: 'resultgroup'
},
	div({
		className: 'resultheader'
	}, shop),
	parseHTML(results, shop).map((res, i) => {
		res.key = i;
		return result(res);
	})
);

Resultgroup.propTypes = {
	shop: PT.string.isRequired,
	//results: PT.array.isRequired
};

export default Resultgroup;