<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Bundle\ResourceBundle\Behat\WebContext as BaseWebContext;
use Symfony\Component\Intl\Intl;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Web context.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class WebContext extends BaseWebContext implements SnippetAcceptingContext
{
    /**
     * @Given /^I am on user login page?$/
     * @When /^I go to user login page?$/
     */
    public function iAmOnTheLoginPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_user_security_login'));
    }

    /**
     * @Then /^I should (?:|still )be on user login page$/
     * @Then /^I should be redirected to user login page$/
     */
    public function iShouldBeOnTheLoginPage()
    {
        $this->assertRoute('sylius_user_security_login');
    }

    /**
     * @Given /^go to "([^""]*)" tab$/
     */
    public function goToTab($tabLabel)
    {
        $this->getSession()->getPage()->find('css', sprintf('.nav-tabs a:contains("%s")', $tabLabel))->click();
    }

    /**
     * @Then /^the page title should be "([^""]*)"$/
     */
    public function thePageTitleShouldBe($title)
    {
        $this->assertSession()->elementTextContains('css', 'title', $title);
    }

    /**
     * @When /^I go to the website root$/
     */
    public function iGoToTheWebsiteRoot()
    {
        $this->getSession()->visit('/');
    }

    /**
     * @Then /^I should (?:|still )be on the store homepage$/
     * @Then /^I should be redirected to the store homepage$/
     */
    public function iShouldBeOnTheStoreHomepage()
    {
        $this->assertRoute('sylius_homepage');
    }

    /**
     * @Given /^I am on the store homepage$/
     */
    public function iAmOnTheStoreHomepage()
    {
        $this->getSession()->visit($this->generateUrl('sylius_homepage'));
    }

    /**
     * @Given /^I am on my account homepage$/
     */
    public function iAmOnMyAccountHomepage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_profile_show'));
    }

    /**
     * @Then /^I should (?:|still )be on my account homepage$/
     */
    public function iShouldBeOnMyAccountHomepage()
    {
        $this->assertRoute('sylius_account_profile_show');
    }

    /**
     * @Given /^I am on my account password page$/
     */
    public function iAmOnMyAccountPasswordPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_change_password'));
    }

    /**
     * @Then /^I should (?:|still )be on my account password page$/
     */
    public function iShouldBeOnMyAccountPasswordPage()
    {
        $this->assertRoute('sylius_account_change_password');
    }

    /**
     * @Given /^I am on my account profile edition page$/
     */
    public function iAmOnMyAccountProfileEditionPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_profile_update'));
    }

    /**
     * @Then /^I should (?:|still )be on my account profile edition page$/
     */
    public function iShouldBeOnMyProfileEditionPage()
    {
        $this->assertRoute('sylius_account_profile_update');
    }

    /**
     * @Then /^I should (?:|still )be on my account profile page$/
     */
    public function iShouldBeOnMyProfilePage()
    {
        $this->assertRoute('sylius_account_profile_show');
    }

    /**
     * @Then /^I should be on my account orders page$/
     */
    public function iShouldBeOnMyAccountOrdersPage()
    {
        $this->assertRoute('sylius_account_order_index');
    }

    /**
     * @Given /^I am on my account orders page$/
     */
    public function iAmOnMyAccountOrdersPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_order_index'));
    }

    /**
     * @Given /^I am on my account addresses page$/
     */
    public function iAmOnMyAccountAddressesPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_address_index'));
    }

    /**
     * @Then /^I should (?:|still )be on my account addresses page$/
     */
    public function iShouldBeOnMyAccountAddressesPage()
    {
        $this->assertRoute('sylius_account_address_index');
    }

    /**
     * @Given /^I am on my account address creation page$/
     */
    public function iAmOnMyAccountAddressCreationPage()
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_account_address_create'));
    }

    /**
     * @Then /^I should (?:|still )be on my account address creation page$/
     */
    public function iShouldBeOnMyAccountAddressCreationPage()
    {
        $this->assertRoute('sylius_account_address_create');
    }

    /**
     * @Then /^I should (?:|still )be on registration page$/
     */
    public function iShouldBeOnRegistrationPage()
    {
        $this->assertRoute('sylius_user_registration');
    }

    /**
     * @Given /^I am on the shipment page with method "([^""]*)"$/
     */
    public function iAmOnTheShipmentPage($value)
    {
        $shippingMethod = $this->findOneBy('shipping_method', array('name' => $value));
        $shipment = $this->findOneBy('shipment', array('method' => $shippingMethod));

        $this->getSession()->visit($this->generatePageUrl('backend_shipment_show', array('id' => $shipment->getId())));
    }

    /**
     * @Then /^I should be on the shipment page with method "([^"]*)"$/
     */
    public function iShouldBeOnTheShipmentPageWithMethod($value)
    {
        $shippingMethod = $this->findOneBy('shipping_method', array('name' => $value));
        $shipment = $this->findOneBy('shipment', array('method' => $shippingMethod));

        $this->assertSession()->addressEquals($this->generatePageUrl('backend_shipment_show', array('id' => $shipment->getId())));
        $this->assertStatusCodeEquals(200);
    }

    /**
     * @Given /^I remove property choice number (\d+)$/
     */
    public function iRemovePropertyChoiceInput($number)
    {
        $this
            ->getSession()
            ->getPage()
            ->find('css', sprintf('.sylius_property_choices_%d_delete', $number))
            ->click()
        ;
    }

    /**
     * @Given /^I am creating variant of "([^""]*)"$/
     */
    public function iAmCreatingVariantOf($name)
    {
        $product = $this->findOneByName('product', $name);

        $this->getSession()->visit($this->generatePageUrl('sylius_backend_product_variant_create', array('productId' => $product->getId())));
    }

    /**
     * @Given /^I should be creating variant of "([^""]*)"$/
     */
    public function iShouldBeCreatingVariantOf($name)
    {
        $product = $this->findOneByName('product', $name);

        $this->assertSession()->addressEquals($this->generatePageUrl('sylius_backend_product_variant_create', array('productId' => $product->getId())));
        $this->assertStatusCodeEquals(200);
    }

    /**
     * @Given /^I added product "([^""]*)" to cart$/
     */
    public function iAddedProductToCart($productName)
    {
        $this->iAmOnTheProductPage($productName);
        $this->pressButton('Add to cart');
    }

    /**
     * @Given /^I fill in province name with "([^"]*)"$/
     */
    public function iFillInProvinceNameWith($value)
    {
        $this->fillField('sylius_country[provinces][0][name]', $value);
    }

    /**
     * @Given /^I fill in the (billing|shipping) address to (.+)$/
     */
    public function iFillInCheckoutAddress($type, $country)
    {
        $base = sprintf('sylius_checkout_addressing[%sAddress]', $type);

        $this->iFillInAddressFields($base, $country);
    }

    /**
     * @Given /^I fill in the users (billing|shipping) address to (.+)$/
     */
    public function iFillInUserAddress($type, $country)
    {
        $base = sprintf('%s[%sAddress]', 'sylius_user', $type);
        $this->iFillInAddressFields($base, $country);
    }

    /**
     * @Given /^I fill in the users account address to (.+)$/
     */
    public function iFillInUserAccountAddress($country)
    {
        $this->iFillInAddressFields('sylius_address', $country);
    }

    protected function iFillInAddressFields($base, $country)
    {
        $this->fillField($base.'[firstName]', 'John');
        $this->fillField($base.'[lastName]', 'Doe');
        $this->fillField($base.'[street]', 'Pvt. Street 15');
        $this->fillField($base.'[city]', 'Lodz');
        $this->fillField($base.'[postcode]', '95-253');
        $this->selectOption($base.'[country]', $country);
    }

    /**
     * @Given /^I select the "(?P<field>([^""]|\\")*)" radio button$/
     */
    public function iSelectTheRadioButton($field)
    {
        $field = str_replace('\\"', '"', $field);
        $radio = $this->getSession()->getPage()->findField($field);

        if (null === $radio) {
            throw new ElementNotFoundException(
                $this->getSession(), 'form field', 'id|name|label|value', $field
            );
        }

        $this->fillField($radio->getAttribute('name'), $radio->getAttribute('value'));
    }

    /**
     * @Then I should not see :position in the menu
     */
    public function iShouldNotSeeInTheMenu($position)
    {
        $this->assertSession()->elementNotContains('css', sprintf('.sidebar-nav'), $position);
    }

    /**
     * @Then I should see :position in the menu
     */
    public function iShouldSeeInTheMenu($position)
    {
        $this->assertSession()->elementContains('css', sprintf('.sidebar-nav'), $position);
    }

    /**
     * @Then I should not see :button button
     */
    public function iShouldNotSeeButton($button)
    {
        $this->assertSession()->elementNotExists('css', '.delete-action-form input[value="'.strtoupper($button).'"]');
    }

    /**
     * @Then I should not see :button button near :user in :table table
     */
    public function iShouldNotSeeButtonInColumnInTable($button, $customer, $table)
    {   
        $this->assertSession()->elementExists('css', "#".$table." tr[data-customer='$customer']");
        $this->assertSession()->elementNotExists('css', "#".$table." tr[data-customer='$customer'] form input[value=".strtoupper($button)."]");
    }

    /**
     * @Then /^I should see product prices in "([^"]*)"$/
     */
    public function iShouldSeeProductPricesIn($code)
    {
        $symbol = Intl::getCurrencyBundle()->getCurrencySymbol($code);
        $this->assertSession()->pageTextContains($symbol);
    }

    /**
     * @Then I should see :count available currencies
     */
    public function iShouldSeeAvailableCurrencies($count)
    {
        $this->assertSession()->elementsCount('css', '.currency-menu ul li', $count);
    }

    /**
     * @When I change the currency to :currency
     */
    public function iChangeTheCurrencyTo($code)
    {
        $symbol = Intl::getCurrencyBundle()->getCurrencySymbol($code);
        $this->clickLink($symbol);
    }

    /**
     * @Then I should see :count available locales
     */
    public function iShouldSeeAvailableLocales($count)
    {
        $this->assertSession()->elementsCount('css', '.locale-menu ul li', $count);
    }

    /**
     * @When I change the locale to :locale
     */
    public function iChangeTheLocaleTo($name)
    {
        $this->clickLink($name);
    }

    /**
     * @Then I should browse the store in :locale
     */
    public function iShouldBrowseTheStoreInLocale($name)
    {
        $text = 'Welcome to Sylius';

        switch ($name) {
            case 'Polish':
            case 'Polish (Poland)':
                $text = 'Witaj w Sylius';
            break;
            case 'German':
            case 'German (Germany)':
                $text = 'Englisch';
            break;
        }

        $this->assertSession()->pageTextContains($text);
    }

    /**
     * For example: I should see 10 products.
     *
     * @Then /^I should see there (\d+) products/
     */
    public function iShouldSeeThatMuchProducts($amount)
    {
        $this->assertSession()->elementsCount('css', '.product', $amount);
    }

    /**
     * @Given /^I am on the product page for "([^"]*)"$/
     * @Given /^I go to the product page for "([^"]*)"$/
     */
    public function iAmOnTheProductPage($name)
    {
        $product = $this->findOneBy('product', array('name' => $name));

        $this->getSession()->visit($this->generatePageUrl($product));
    }

    /**
     * @Then /^I should be on the product page for "([^"]*)"$/
     * @Then /^I should still be on the product page for "([^"]*)"$/
     */
    public function iShouldBeOnTheProductPage($name)
    {
        $product = $this->findOneBy('product', array('name' => $name));

        $this->assertSession()->addressEquals($this->generateUrl($product));
    }

    /**
     * @Given /^I am on the order ([^""]*) page for (\d+)$/
     * @Given /^I go to the order ([^""]*) page for (\d+)$/
     */
    public function iAmOnTheOrderPage($action, $number)
    {
        $order = $this->findOneBy('order', array('number' => $number));

        $this->getSession()->visit($this->generatePageUrl('sylius_account_order_'.$action, array('number' => $order->getNumber())));
    }

    /**
     * @Then /^I should be on the order ([^""]*) page for (\d+)$/
     * @Then /^I should still be on the order ([^""]*) page for (\d+)$/
     */
    public function iShouldBeOnTheOrderPage($action, $number)
    {
        $this->assertSession()->addressEquals($this->generatePageUrl('sylius_account_order_'.$action, array('number' => $number)));
    }

    /**
     * @Given /^I am not authenticated$/
     * @Given /^I am not logged in anymore$/
     */
    public function iAmNotAuthenticated()
    {
        $this->getSecurityContext()->setToken(null);
        $this->getContainer()->get('session')->invalidate();
    }

    /**
     * @Given /^I log in with "([^""]*)" and "([^""]*)"$/
     */
    public function iLogInWith($email, $password)
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_user_security_login'));

        $this->fillField('Email', $email);
        $this->fillField('Password', $password);
        $this->pressButton('Login');
    }

    /**
     * @Given /^I add following option values:$/
     */
    public function iAddFollowingOptionValues(TableNode $table)
    {
        $count = count($this->getSession()->getPage()->findAll('css', 'div.collection-container div.control-group'));

        foreach ($table->getRows() as $i => $value) {
            $this->getSession()->getPage()->find('css', 'a:contains("Add value")')->click();
            $this->fillField(sprintf('sylius_option[values][%d][value]', $i+$count), $value[0]);
        }
    }

    /**
     * @When /^I click the login with (.+) button$/
     * @When /^I press the login with (.+) button$/
     */
    public function iClickTheLoginWithButton($provider)
    {
        $loginButton = $this->getSession()->getPage()->find('css', sprintf('a.oauth-login-%s', strtolower($provider)));
        $loginButton->click();

        // Re-set default session
        $currentUrl = $this->getSession()->getCurrentUrl();
        $this->getMink()->setDefaultSessionName('goutte');
        $this->getSession()->visit($currentUrl);
    }

    /**
     * @Given /^I added product "([^""]*)" to cart, with quantity "([^""]*)"$/
     * @When /^I add product "([^""]*)" to cart, with quantity "([^""]*)"$/
     */
    public function iAddedProductToCartWithQuantity($productName, $quantity)
    {
        $this->iAmOnTheProductPage($productName);
        $this->fillField('Quantity', $quantity);
        $this->pressButton('Add to cart');
    }

    /**
     * @Given /^I finish the checkout process$/
     */
    public function iFinishTheCheckoutProcess()
    {
        $this->iFillInCheckoutAddress('shipping', 'United Kingdom');
        $this->pressButton('Continue');
        $this->iSelectTheRadioButton('DHL Express');
        $this->pressButton('Continue');
        $this->iSelectTheRadioButton('Credit Card');
        $this->pressButton('Continue');
        $this->iClick('Place order');
        $this->assertSession()->pageTextContains('Thank you for your order!');
    }

    /**
     * @Then /^I should see ([^""]*) "([^""]*)" for "([^""]*)"$/
     */
    public function iShouldSeeQuantityFor($property, $expectedValue, $item)
    {
        $tr   = $this->assertSession()->elementExists('css', sprintf('table tbody tr:contains("%s")', $item));
        $rows = $this->getSession()->getPage()->findAll('css', 'table thead tr th');

        $column = null;
        foreach ($rows as $key => $row) {
            if ($row->getText() === $property) {
                $column = $key;
                break;
            }
        }

        $cols = $tr->findAll('css', 'td');

        \PHPUnit_Framework_Assert::assertEquals($expectedValue, $cols[$column]->getText());
    }

    /**
     * @Given I view deleted elements
     */
    public function iViewDeletedElements()
    {
        $this->clickLink('Show deleted');
    }
    
    /**
     * @Then I should see table of :id sorted by lastName
     */
    public function iShouldSeeTableSortedByLastName($id)
    {
        $allNames = $this->getSession()->getPage()->findAll('css', '#'.$id.' > tbody > tr > td > p');
        $allSurnames = array();
        
        foreach ($allNames as $name){
            $spacePosition = strpos($name->getText(), ' ');
            $surname = substr($name->getText(), $spacePosition + 1);
            $allSurnames[] .= $surname;
        }
        
        sort($allSurnames);
        
        $this->assertSession()->elementTextContains('css', '#'.$id.' > tbody > tr > td > p', $allSurnames[0]);
    }

    /**
     * @Given I registered with email :email and password :password
     */
    public function iRegisteredWithEmailAndPassword($email, $password)
    {
        $this->getSession()->visit($this->generatePageUrl('sylius_user_registration'));

        $this->fillField('First name', $this->faker->firstName);
        $this->fillField('Last name', $this->faker->lastName);
        $this->fillField('Email', $email);
        $this->fillField('Password', $password);
        $this->fillField('Verification', $password);
        $this->pressButton('Register');
    }

    /**
     * @When /^(?:|I )fill in guest email with "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function fillGuestEmail($value)
    {
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField('sylius_customer_guest[email]', $value);
    }

    /**
     * @When /^I display ([^""]*)$/
     */
    public function iDisplayPage($page)
    {
        $pageMapping = array(
            'my orders history' => 'sylius_account_order_index',
            'my address book'   => 'sylius_account_address_index'
        );

        $this->getSession()->visit($this->generatePageUrl($pageMapping[$page]));
    }

    /**
     * @When I restart my browser
     */
    public function iRestartMyBrowser()
    {
        $session = $this->getSession();
        $cookie = $session->getCookie('REMEMBERME');

        $session->restart();
        $session->setCookie('REMEMBERME', $cookie);
    }

    /**
     * @Given /^I go to page for product with empty slug$/
     */
    public function iGoToPageForProductWithEmptySlug()
    {
        $this->visitPath('/p/');
    }

    private function assertRoute($route)
    {
        $this->assertSession()->addressEquals($this->generatePageUrl($route));

        try {
            $this->assertStatusCodeEquals(200);
        } catch (UnsupportedDriverActionException $e) {
        }
    }
}
