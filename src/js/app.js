'use strict';

// I hate this about webpack
require('../scss/app.scss');

import React, {DOM, createClass, createFactory} from 'react';
import ReactDOM from 'react-dom';

import {fetcher} from './server';

import Searchbox from './components/Searchbox';
import Shopslist from './components/Shopslist';
import Resultgroup from './components/Resultgroup';

import {SHOPS} from './constants/shops';

const {div} = DOM;

const [searchbox, shopslist, resultgroup] = [Searchbox, Shopslist, Resultgroup].map(createFactory);

const App = createClass({

	getInitialState() {
		return {
			activeShops: SHOPS,
			query: null,
			results: []
		}
	},

	onSubmit(e) {
		e.preventDefault();

		this.setState({
			results: []
		});

		const {query, activeShops} = this.state;

		fetcher(query, activeShops, res => this.setState({
			results: this.state.results.concat([res])
		}));
	},

	setShops(shops) {
		return this.setState({
			activeShops: shops
		});
	},

	onQueryChange(e) {
		return this.setState({
			query: e.target.value
		});
	},

	render() {
		return div({
			className: 'wrapper'
		},
			searchbox({
				onChange: this.onQueryChange,
				onSubmit: this.onSubmit
			}),
			shopslist({
				activeShops: this.state.activeShops,
				onSetShops: this.setShops
			}),
			this.state.results.map((res, i) => {
				res.key = i;
				return resultgroup(res);
			})
		);
	}
});

ReactDOM.render(React.createElement(App), document.getElementById('content'));