# ConsoleProcessManagerSonataAdminBundle
Provides a way to logging all console events

### Configuration

#### Register `ConsoleProcessManagerSonataAdminBundle` in your app.
Add `RedCircle\ConsoleProcessManagerSonataAdminBundle\ConsoleProcessManagerSonataAdminBundle::enable($application);` in your console file in app directory. 

**Example of `AppKernel.php` file:**
```
class AppKernel extends Kernel
{
    public function registerBundles()
    { 
        $bundles = array(
            ...
            new RedCircle\ConsoleProcessManagerSonataAdminBundle\ConsoleProcessManagerSonataAdminBundle(),
        );

    return $bundles;
    }
}