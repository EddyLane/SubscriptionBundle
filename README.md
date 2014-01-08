[![Build Status](https://travis-ci.org/EddyLane/SubscriptionBundle.png?branch=master)](https://travis-ci.org/EddyLane/SubscriptionBundle)

FridgeSubscriptionBundle
========================

**Note:**

> This bundle is still in active development and is not ready for production.
> Both the documentation for this bundle and the bundle itself are still very much a work in progress.
> More information coming soon

## Introuction

The FridgeSubscriptionBundle provides everything you need to implement subscription plans and recurring payments in your Symfony2 application.

## Prerequisites

1. This bundle requires PHP 5.4+
2. This bundle requires you have a stripe account
3. This bundle requires that you are using the Doctrine ORM

## Installation

1. Download FridgeSubscriptionBundle using composer
2. Enable the Bundle
3. Create association between your User class and a StripeProfile
4. Configure the FridgeSubscriptionBundle
5. Import FridgeSubscriptionBundle webhook routing
6. Update your database schema

### Step 1: Download FridgeSubscriptionBundle using composer

Add FridgeSubscriptionBundle in your composer.json:

```js
{
    "require": {
        "fridge/subscription-bundle": "dev-master",    
    }
}
```
Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fridge/subscription-bundle
```

Composer will install the bundle to your project's `vendor/fridge` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Fridge\SubscriptionBundle\FridgeSubscriptionBundle(),
    );
}
```
### Step 4: Create association between your User class and a StripeProfile

This bundle assumes that you already have implemented your own User class. If you have not then a good place to look is the FOSUserBundle.

This bundle provides a StripeProfile entity that has a one-to-one association with your User. As the User must have the owning side of the association you must add this.

If you use annotations:

##### annotation

``` php
<?php

    /**
     * @ORM\OneToOne(targetEntity="Fridge\SubscriptionBundle\Entity\StripeProfile", cascade={"all"})
     * @ORM\JoinColumn(name="stripe_profile_id", referencedColumnName="id")
     */
    protected $stripeProfile;
```

If you use yaml:

##### yaml

``` yml
oneToOne:
    stripeProfile:
      targetEntity: Fridge\SubscriptionBundle\Entity\StripeProfile
      cascade: all
      joinColumn:
        name: stripe_profile_id
        referencedColumnName: id
``` 

Finally add a getter/setter for the stripe profile to your user entity:

    public function setStripeProfile(StripeProfile $stripeProfile)
    {
        $this->stripeProfile = $stripeProfile;

        return $this;
    }

    public function getStripeProfile()
    {
        if(!$this->stripeProfile) {
            $this->setStripeProfile(new StripeProfile);
        }

        return $this->stripeProfile;
    }


### Step 4: Configure the FridgeSubscriptionBundle

This bundle needs to be aware of your User class.

Full configuration options coming soon.

``` yaml
# app/config/config.yml

fridge_subscription:
    user_class: Fridge\UserBundle\Entity\User
    stripe_sk: YourLiveStripeKey

```

``` yaml
# app/config/config_dev.yml

fridge_subscription:
    user_class: Fridge\UserBundle\Entity\User
    stripe_sk: YourTestStripeKey

```

``` yaml
# app/config/config_test.yml

fridge_subscription:
    user_class: Fridge\UserBundle\Entity\User
    stripe_sk: YourTestStripeKey

```

### Step 5: Import FridgeSubscriptionBundle webhook routing

Now that you have activated and configured the bundle, all that is left to do is
import the FridgeSubscriptionBundle webhook routing.

By importing the routing files you will allow stripe to call your server to inform it of events such as invoice payment failures, and allow the bundle to take action such as cancelling users subscriptions.

In YAML:

``` yaml
# app/config/routing.yml
fridge_subscription_routing:
    resource: "@FridgeSubscriptionBundle/Resources/config/routing.yml"
    type: rest
```

Or if you prefer XML:

``` xml
<!-- app/config/routing.xml -->
<import resource="@FridgeSubscriptionBundle/Resources/config/routing.yml" type="rest" />
```


### Step 6: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema to add the FridgeSubscriptionBundle entities are create the association with your User entity.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```


More information coming soon
