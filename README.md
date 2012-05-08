laravelSexyForm
===============

Sexy forms for laravel, all dressed up for you!

Installation Instructions:
--------------------------

Copy the folder above onto Laravel's route directory. Done!

Usage:
------

In your view:

    <table>
        <tr>
            <?php echo FormHelper::text('Fancy name goes here', $errors); ?>
        </tr>
        <tr>
            <?php echo FormHelper::text(array('Fancy Name here', 'NotSoFancyPOSTNameOverride'), $errors, "Default Value Goes Here"); ?>
        </tr>
    </table>

In your validation:

    $foo = Input::get('fancyNameGoesHere');

There's a bunch of different form elements available in FormHelper:

| Name     | Usage                                 |
|:--------:|:-------------------------------------:|
| text     | FormHelper::text('foo', $errors);     |
| password | FormHelper::password('foo', $errors); |
| textArea | FormHelper::textArea('foo', $errors); |
