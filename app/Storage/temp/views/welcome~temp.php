
<h2>Getting Started</h2>
<p>
    Getting started with panther is really easy, you can do that by 
    either using <code>GIT</code> or by just directly downloading 
    repository as zip from <code>https://github.com/alinawaz/panther</code>.
</p>
<h5>Using GIT</h3>
<p>
    Goto your <code>XAMPP/WAMP</code> root folder <code>www/htdocs</code> or any other stack you have installed for 
    php & mysql. <br/>
    Open up <code>Command Prompt Or Terminal</code> and type in 
    <div class="card">
        <div class="card-body">
            git clone https://github.com/alinawaz/panther
        </div>
    </div>
    <br/>
    You can rename <code>panther</code> to any name of your project you want. 
    For now let it be panther and let's <code>cd</code> into the directory
    <br/><br/>
    <div class="card">
        <div class="card-body">
            cd panther
        </div>
    </div>
    <br/>
</p>
<h5>Installing dependencies via composer</h3>
<p>
    Panther uses <code>composer</code> to utilize PSR standard & for symfony 
    dependencies. <br/><br/>
    <div class="alert alert-secondary" role="alert">
        Make sure you already have a <a href="https://getcomposer.org/download/">composer</a> installed.
    </div>
    <br/>
    Now run the following command for install required dependencies for panther.
    <br/><br/>
    <div class="card">
        <div class="card-body">
            composer install
        </div>
    </div>
</p>
<h5>That's it, let's test it out.</h3>
<p>
    Let's test out our new installation of panther. Panther comes with default 
    entity named <code>HelloEntity</code> which have a home page at 
    <code>http://your_local_host_url/project_folder/</code>
    <br/><br/>
    You will see welcome page from panther.
</p>