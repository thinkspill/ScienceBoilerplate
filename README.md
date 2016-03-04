# ScienceBoilerplate
DoesScience trait handles some of the boilerplate associated with performing experimental code refactoring using Science!

```php
<?php

class myClass
{
  public function main()
  {
    $result = $this->oldCreakyMethod();
  }
  
  // ...
}
```


Lets refactor `oldCreakyMethod` by starting from some boilerplate:


```php
<?php

class myClass
{
  use \thinkspill\DoesScience;
  
  public function main()
  {
    /** boilerplate start */
    $control = function (...$vars) {
        return call_user_func_array([$this, 'oldCreakyMethod'], func_get_args());
    };

    $trial = function (...$vars) {
        return call_user_func_array([$this, 'newShinyMethod'], func_get_args());
    };

    $this->makeScienceExperiment('Experiment Name', $control);
    $this->addExperimentTrial('trial 1', $trial);

    ~r($this->experimentReport($arg1, $arg2));
    /** boilerplate end */

    // $result = $this->oldCreakyFunction($arg1, $arg2);
  }
  
  private function oldCreakyMethod($arg1, $arg2)
  { 
    // ...
  }
  private function newShinyMethod($arg1, $arg2)
  { 
    // ...
  }
}
```

The experiment boilerplate code gets copy/pasted into
the code location that calls the method being refactored,
and modified to call the correct control and trial methods.

The only call that needs to retain the actual arguments of the
method under refactor are those in the experimentReport call,
due to the use of variable arguments everywhere else.
