<?php 

use Illuminate\Support\ServiceProvider;

/**
* Service provider to add the console command to laravel
*/
class EmailMarketerServiceProvider extends ServiceProvider
{
	
	/**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEmailCommandGenerator();
    }
     /**
     * Register the mail:campaign command.
     */
    private function registerEmailCommandGenerator()
    {
        $this->app->singleton('command.mail.campaign', function ($app) {
            return $app['Maxdeviper\EmailMarkerter\MailCampaigner'];
        });

        $this->commands('command.mail.campaign');
    }
}