'use strict';

import React, {DOM, createClass, PropTypes as PT} from 'react';

const {div, input} = DOM;

const Searchbox = createClass({

	propTypes: {
		onChange: PT.func.isRequired
	},

	render() {
		return div({
			className: 'searchbox'
		},
			input({
				type: 'text',
				ref: 'searchfield',
				onChange: this.props.onChange,
				placeholder: 'search'
			})
		);
	}
});

export default Searchbox;