# Bootstrap for Ditto
**a Ditto bundle**

You can pick and choose the parts of Bootstrap to load.

## Use
```php
Engine::load()->bundle('Bootstrap')
	->load([
		'buttons',
		'forms'
	]);
```

The CSS and JS files for buttons and forms along with their depenencies will then be inserted into the template.