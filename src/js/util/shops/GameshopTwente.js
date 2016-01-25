'use strict';

import {_getBody} from '../parseHTML';

const GameshopTwenteHandler = dom => {
	const body = _getBody(dom);

	console.log(body);

	return body;
};

export default GameshopTwenteHandler;