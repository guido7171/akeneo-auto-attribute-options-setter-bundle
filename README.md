# AutoAttributeOptionsSetterBundle

This bundle ensure that attribute options are created automatically when importing products for simple select and multi select attribute.

## Installation

- Execute the following command to add the dependency to your `composer.json`

`composer require niji/auto-attribute-options-setter-bundle`

- In your config/bundles.php add a line to enable the bundle:
   

  return [
      Niji\AutoAttributeOptionsSetterBundle\AutoAttributeOptionsSetterBundle::class => [ 'all' => true],
      ...
  
## Credits

This bundle is brought to you by Niji - http://www.niji.fr.
