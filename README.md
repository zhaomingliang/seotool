<h1>搜索引擎优化工具v2（译：中文版）</h1>
<p>&nbsp;</p>
<h2><a id="user-content-voraussetzungen" href="https://github.com/zhaomingliang/seotool#voraussetzungen" aria-hidden="true"> </a>前提条件</h2>
<p>像第一个版本：有必要通过SSH执行cron作业，即正常的网络空间是不够的规则。这样做的原因是，要执行的程序写入Perl和根据关键字的长达45分钟的时间是活动的数量。有些事情难以实施，使用PHP，你将不得不在某些服务器配置的变化（最大Exec的时间有关，...）。</p>
<p><strong>否则：</strong></p>
<ul>
  <li>用SSH访问服务器（即网络空间不适合）</li>
  <li>PHP 5.6（和PHP 7.0.0兼容）</li>
  <li>MYSQL 5.5</li>
  <li>PERL 5:20</li>
  <li>一些Perl模块（包括LWP ::简单）</li>
  <li>基本的服务器管理技巧</li>
  <li>子域</li>
</ul>
<h2><a id="user-content-funktionsumfang" href="https://github.com/zhaomingliang/seotool#funktionsumfang" aria-hidden="true"> </a>特点</h2>
<ul>
  <li>一般的仪表板，显示关键人物</li>
  <li>关键字查询您的项目包括注册的竞争对手</li>
  <li>赢/输/机会关键字</li>
  <li>每个关键字的搜索量来注册</li>
  <li>所有的表都可以搜索和分类</li>
  <li>图的排名，有竞争力的比较，加工关键词</li>
  <li>管理简单的方式设置反向 - 反向链接管理</li>
  <li>对号码或关键字项目数量没有限制</li>
  <li>每个关键字可以手动与Suvo添加</li>
  <li>是Suvo注册，可以计算等级值</li>
  <li>系统状态和技巧</li>
</ul>
<h2><a id="user-content-installationsanleitung" href="https://github.com/zhaomingliang/seotool#installationsanleitung" aria-hidden="true"> </a>安装说明</h2>
<p>我问究竟要仔细阅读以下声明并遵守。安装过程设计在这里不trifvial，谁愿意使用该工具，而不是在一个位置，它被设置，我可以租一个小服务器设置工具。这里盛产小的虚拟服务器进行完全。</p>
<h3><a id="user-content-schritt-1-subdomain-einrichten" href="https://github.com/zhaomingliang/seotool#schritt-1-subdomain-einrichten" aria-hidden="true"> </a>第1步：设置子域</h3>
<p>该工具仅在一个子域。这使得你的域之一 - 通用顶级域名或IP地址也将工作。</p>
<h3><a id="user-content-schritt-2-repo-klonen-oder-herunterladen" href="https://github.com/zhaomingliang/seotool#schritt-2-repo-klonen-oder-herunterladen" aria-hidden="true"> </a>步骤2：回购克隆或下载</h3>
<p>只是所有你在回购看到这些文件在这里复制到适当的位置或者下载安装包。晴这是这样的：/var/www/euredomain.de/web/</p>
<h3><a id="user-content-schritt-3-htaccessnginx-anpassen" href="https://github.com/zhaomingliang/seotool#schritt-3-htaccessnginx-anpassen" aria-hidden="true"> </a>第3步：自定义的.htaccess / nginx的</h3>
<p>该工具已被编程的SLIM架构3 <a href="http://www.slimframework.com/docs/start/web-servers.html" target="_blank">RC2，并根据以下说明适用：进入slimframework.com</a></p>
<p>重要提示：对公共/显示Dokumentenroot必须的。这就是推动她的子域的目录。所有重要的文件都可以访问该文件夹以外，并且因此不给用户通过网络浏览器！</p>
<h3><a id="user-content-schritt-4-composer-initialisieren-und-abhängigkeiten-installieren" href="https://github.com/zhaomingliang/seotool#schritt-4-composer-initialisieren-und-abhängigkeiten-installieren" aria-hidden="true"> </a>第4步：初始化Composer和安装依赖</h3>
<p>通过SSH，改变登录的所有文件的目录和&ldquo;作曲安装&rdquo;，然后&ldquo;作曲倾倒自动加载-o可以安装&rdquo;所有依赖关系。这些文件将记录在composer.json。这是很重要的，否则，只是缺少的工具的重要组成部分。<a href="https://getcomposer.org/" target="_blank">使用作曲家的一般说明可以发现getcomposer.org</a></p>
<h3><a id="user-content-schritt-5-einstellungen-anpassen" href="https://github.com/zhaomingliang/seotool#schritt-5-einstellungen-anpassen" aria-hidden="true"> </a>第5步：调整设置</h3>
<p>在应用程序/ settings.php文件，并安装/ seotracker.pl MySQL数据库的凭据必须适应，包括数据库名。</p>
<h3><a id="user-content-schritt-6-import-des-sql-dumps" href="https://github.com/zhaomingliang/seotool#schritt-6-import-des-sql-dumps" aria-hidden="true"> </a>第6步：导入SQL转储</h3>
<p>在安装/有一个SQL转储，其中有要导入到数据库中。</p>
<h3><a id="user-content-schritt-7-cronjob-einrichten" href="https://github.com/zhaomingliang/seotool#schritt-7-cronjob-einrichten" aria-hidden="true"> </a>第7步：设置cron作业</h3>
<p>在cron作业必须设置如下。每隔一小时，必须开始一小时的cron作业。作为一项规则，通过SSH登录到服务器，并开始&ldquo;的crontab -e&rdquo;。这里蕴藏着东西到窗体：</p>
<p><em>0 * * * * perl的/var/www/pfad/zur/datei/web/cron/seotracker.pl</em></p>
<h3><a id="user-content-schritt-8-perl-datei-prüfen" href="https://github.com/zhaomingliang/seotool#schritt-8-perl-datei-prüfen" aria-hidden="true"> </a>第8步：检查PERL文件</h3>
<p>它需要一些特殊的Perl模块，这些都是很容易通过C​​PAN进行安装。需要什么，你可以学习，你只要看看在&ldquo;安装/&rdquo;的PERL文件 - 启动文件夹中：perl的seotracker.pl</p>
<p>有错误，可以预期的，如：&ldquo;能不能找到LWP / Simple.pm inINC（您可能需要安装LWP ::简单的模块）&rdquo;</p>
<p>在控制台的解决方案：须藤的perl -MCPAN -e'install&ldquo;LWP ::简单''</p>
<h3><a id="user-content-schritt-9-im-browser-urlsubdomain-aufrufen" href="https://github.com/zhaomingliang/seotool#schritt-9-im-browser-urlsubdomain-aufrufen" aria-hidden="true"> </a>第9步：调用浏览器的URL /子域名</h3>
<p>随着默认的登录数据，您可以登录并开始创建项目。关键字数据从第二天更新在先前配置的计划作业。</p>
<h3><a id="user-content-tipp-fakedaten-generieren" href="https://github.com/zhaomingliang/seotool#tipp-fakedaten-generieren" aria-hidden="true"> </a>提示：生成Fakedaten</h3>
<p>要通过呼叫测试一切与Fakedaten，可这http://eure.domain.de/mocker/产生迅速和容易。为了这个目的，你不过之前登录。原因很简单，接入是免费的，谁知道，你的工具，删除您的数据并更换gemockten数据的可能。WERS不需要，可以删除的应用程序/ routes.php文件的相关部分！</p>
<h2><a id="user-content-fragenaufträge-und-hilfe" href="https://github.com/zhaomingliang/seotool#fragenaufträge-und-hilfe" aria-hidden="true"> </a>问题/订单和帮助</h2>
<p>有问题吗？我能帮忙，否则？你需要一个开发者？想参与，建立包括服务器的工具？给我写一封通过电子邮件damianschwyrz.de！</p>
<h2><a id="user-content-screenshots---einige-eindrücke-des-tools" href="https://github.com/zhaomingliang/seotool#screenshots---einige-eindrücke-des-tools" aria-hidden="true"> </a>截图 - 的工具的印象</h2>

<img src="http://i.imgur.com/cDcseJ3.png">
<img src="http://i.imgur.com/yIQuTXI.png">
<img src="http://i.imgur.com/GJTjcFt.png">
<img src="http://i.imgur.com/S8tTjD1.png">