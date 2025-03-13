# View Request Headers

Vrh-php is a webpage of PHP that can be deployed in an Azure Web App, or web server with PHP. This allows you to quickly confirm what Request Headers are being received in the event you're going through a proxy, chaining web services, or applying rewrites to Client requests in a service.

## Quickstart on Azure Web App

- An Azure account with an active subscription. [Create an account for free](https://azure.microsoft.com/free/).
- [Git](https://git-scm.com/)
- [PHP](https://php.net/manual/install.php)
- [Azure CLI](/cli/azure/install-azure-cli) to run commands in any shell to create and configure Azure resources.

### Using Azure CLI

1. In a terminal window, run the following commands to clone the application to the local environment and navigate to the project root.

   ```bash
   git clone https://github.com/b-rito/vrh-PHP
   cd vrh-PHP
   ```

1. Using Azure CLI command `az webapp up`, to create or update your Azure Web App in a single step. This will deploy the code in your local folder from where the command is executed.

   ```azurecli
   az webapp up --runtime "PHP:8.2" --os-type=linux
   ```

   - Only specifying the `--runtime` and `--os-type` will leave other values to automatically generate
   - Options that are common to specify
     - `--name myFirstWebApp`
     - `--resource-group myResourceGroup`
     - `--location eastus2` (az account list-locations)
     - `--sku B1`
   - More information available on Azure CLI [az webapp up](https://learn.microsoft.com/en-us/cli/azure/webapp?view=azure-cli-latest#az-webapp-up)

### Web App Configuration
Once the Azure Web App is deployed and running, you may notice that only the default domain page works: `https://<default-domain>.net`

To allow any URL Path to be recognized in the event of rewrites or redirections that may extent the 'RequestUri' similar to: `https://<default-domain>.net/helloworld` you can update the Web App.  

> [!NOTE]
> Persistent '/home' storage is needed via Environment Variable `WEBSITES_ENABLE_APP_SERVICE_STORAGE = true`  

1. Connect to the Web App via SSH
   - Login to Azure Portal and navigate to your deployed Azure Web App
   - Expand 'Development Tools', click on 'SSH', and open the web-browser based SSH connection
1. Update the Web App's Nginx configuration via `vi`
   - From the `/home#` prompt copy the nginx configuration
      ```bash
      cp /etc/nginx/sites-enabled/default /home/default
      ```
   - Update the nginx configuration using the built-in editor
      ```bash
      vi /home/default
      ```
      - `vi` is an editor that uses two modes, either `Insert` or `Command`, target `Insert` by pressing the letter `i`
      - Using arrow keys to navigate towards the `location /` section to modify it to look similar to
      ```nginx
      location / {
         try_files $uri /index.php;
      }
      ```
      - To save the configuration changes, press *ESC*,  type `:wq`, then *Enter*
1. Apply changes and reload nginx 
   - Copy the new configuration back to the necessary directory
      ```bash
      cp /home/default /etc/nginx/sites-enabled/default
      ```
   - Reload nginx to apply the changes without restarting the Web App
      ```bash
      service nginx reload
      ```
   - You should now see similar webpage presented when requesting any combination of URL Paths
      - `https://<defaultdomain>.net/helloworld`
      - `https://<defaultdomain>.net/this/longer/path`
1. Optionally, you can persist this change on restarts of the Web App
   - Navigate to the Azure Portal and go to your Web App
   - Expand 'Settings', click on 'Configuration', and input a 'Startup Command'
      ```bash
      cp /home/default /etc/nginx/sites-enabled/default; service nginx reload
      ```
   - Once the command is entered, apply the change by 'Save'