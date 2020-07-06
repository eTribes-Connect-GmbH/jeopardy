#jeopardy

You need the basic symfony runtime.  
You also need a running mysql server.

## Install
Checkout ```git@gitlab.netshops-system.com:internal-projects/skills.git```  
Run ```docker-compose up -d```  
Run ```docker cp ./ci/skillz.sql skillz_mysql:/tmp/skillz.sql```  
Run ```docker-composer exec mysql bash```   
Run ```mysql -uroot -proot skillz < /tmp/skillz.sql```    
Leave the mySqlDockerEnv  
Run ```docker-composer exec webserver bash```    
Run ```composer install```  
Leave the webserverDockerEnv    
Run ```yarn install```    
Run ```yarn dev```    
Create a new entry in your Hosts file:  
```127.0.0.1   skillz.local```

## App
Only @etribes.de emails could be registred 

## CodeChecks
For php-codeChecks go into dockerEnv with:   
```docker-compose exec webserver bash ```  
From here you execute the different checks via composer  
```
code:sniff:php      // phpcs     
code:sniff:php-fix  // phpcbf     
code:sniff:php-md   // phpmd 
```

For frontend-codeChecks leave the dockerEnv  
From the projectRoot you simply run:
```
code:check:style        // npx stylelint assets/scss/**/*.scss
code:check:style:fix    // npx stylelint assets/scss/**/*.scss --fix
code:check:js           // npx eslint assets/js/**
code:check:js:fix       // npx eslint assets/js/** --fix
```