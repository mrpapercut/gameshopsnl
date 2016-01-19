'use strict';

import React, {DOM, createClass, PropTypes as PT} from 'react';
import ReactDOM from 'react-dom';

import {SHOPS as allShops} from '../constants/shops';

const {div, ul, li, input, label} = DOM;

const Shopslist = createClass({
	propTypes: {
		activeShops: PT.array.isRequired,
		onSetShops: PT.func.isRequired
	},

	onChange(e) {
		const {name, checked} = e.target;
		const {activeShops} = this.props;

		this.props.onSetShops(checked ? activeShops.concat([name]) : this.props.activeShops.filter(s => s !== name));
	},

	render() {
		return div({
			className: 'shopslist'
		},
			ul(null,
				allShops.map(shop => li({
					key: allShops.indexOf(shop)
				},
					input({
						type: 'checkbox',
						defaultChecked: this.props.activeShops.indexOf(shop) !== -1,
						name: shop,
						ref: shop,
						id: shop,
						onChange: this.onChange
					}),
					label({
						htmlFor: shop
					}, shop)
				))
			)
		);
	}
});

export default Shopslist;
