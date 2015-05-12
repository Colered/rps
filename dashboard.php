<?php
include('header.php');?>
<p>What changed?

First, there is a new JavaScript file that contains a controller. More exactly, the file contains a constructor function that creates the actual controller instance. The purpose of controllers is to expose variables and functionality to expressions and directives.

Besides the new file that contains the controller code we also added an ng-controller directive to the HTML. This directive tells Angular that the new InvoiceController is responsible for the element with the directive and all of the element's children. The syntax InvoiceController as invoice tells Angular to instantiate the controller and save it in the variable invoice in the current scope.

We also changed all expressions in the page to read and write variables within that controller instance by prefixing them with invoice. . The possible currencies are defined in the controller and added to the template using ng-repeat. As the controller contains a total function we are also able to bind the result of that function to the DOM using {{ invoice.total(...) }}.

Again, this binding is live, i.e. the DOM will be automatically updated whenever the result of the function changes. The button to pay the invoice uses the directive ngClick. This will evaluate the corresponding expression whenever the button is clicked.</p>
<?php include('footer.php');
?>

