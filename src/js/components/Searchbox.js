'use strict';

import React, {DOM, createElement, PropTypes as PT} from 'react';

const {div, form, button, input} = DOM;

const Searchbox = ({onChange, onSubmit}) => div({
	className: 'searchbox'
},
	form({
		onSubmit: onSubmit
	},
		input({
			type: 'text',
			onChange: onChange,
			placeholder: 'search'
		}),
		button({
			className: 'submit'
		})
	)
);

Searchbox.propTypes = {
	onChange: PT.func.isRequired,
	onSubmit: PT.func.isRequired
};

export default Searchbox;
