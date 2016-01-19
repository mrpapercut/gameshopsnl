'use strict';

import {SHOPS} from '../constants/shops';

export const fetcher = (query, shops, cb) =>
	shops.forEach(shop => getResults(query, shop, cb));

const getResults = (query, shop, cb) => {
	const formData = new FormData();

	formData.append('query', query);
	formData.append('shop', shop);

	fetch('search.php', {
		method: 'POST',
		headers: {
			'Accept': 'application/json'
		},
		body: formData
	})
	.then(res => res.json())
	.then(res => cb(res))
	.catch(err => console.error(err));
};