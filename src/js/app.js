'use strict';

import React, {DOM, createClass, createFactory} from 'react';
import ReactDOM from 'react-dom';

import Searchbox from './components/Searchbox';

const {div} = DOM;

const [searchbox] = [Searchbox].map(createFactory);

const App = createClass({

	onChange(e) {
		const formData = new FormData();
		formData.append('query', e.target.value);
		formData.append('shop', 'GamelandGroningen');

		fetch('search.php', {
			method: 'POST',
			headers: {
				'Accept': 'application/json'
			},
			body: formData
		})
		.then(res => res.json())
		.then(res => console.log(res))
		.catch(err => console.error(err));
	},

	render() {
		return div({
			className: 'wrapper'
		},
			searchbox({
				onChange: this.onChange
			})
		);
	}
});

ReactDOM.render(React.createElement(App), document.getElementById('content'));