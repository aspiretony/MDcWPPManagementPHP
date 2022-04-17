<?php
use Linfo\Linfo;

class SystemInformationView extends TPage
{
    private $info;
    private $settings;
    private $cpu_usage;
    private $cpu_usage_value;

    public function __construct()
    {
        parent::__construct();

        $this->cpu_usage = FALSE;
        $this->getInfo();

        $system_information        = new TElement("div");
        $system_information->class = "row";
        $system_information->style = "padding-top: 20px;";

        $system_information->add($this->getMemoryInfo());
        if ($this->cpu_usage)
        {
            $system_information->add($this->getCpuUsage());
        }
        $system_information->add($this->getCpuInfo());
        $system_information->add($this->createPanelSystemInfo());
        $system_information->add($this->createPanelSystemProcess());
        $system_information->add($this->getDiskInfo());
        $system_information->add($this->getNetWorkInfo());

        $temps = $this->getTemperatureInfo();

        foreach ($temps as $value)
        {
            $system_information->add($value);
        }

        parent::add($system_information);
        parent::add($this->createRefreshButton());
    }

    public function createRefreshButton()
    {
        $a            = new TElement("a");
        $a->href      = "index.php?class=SystemInformationView";
        $a->generator = "adianti";
        $a->class     = "btn btn-primary btn-circle-lg waves-effect waves-circle waves-float";
        $a->style     = "border-radius:50%;width:50px;height:50px;position:fixed;right:30px;bottom:10px";
        $icon = new TImage("fa:sync");
        $icon->style = "line-height:40px;font-size:24px !important";

        $a->add($icon);
        $a->title = _t("Reload");

        return $a;
    }

    /**
     * Linfo get system information
     *
     * @author Artur Comunello <arturcomunello@gmail.com>
     */
    private function getInfo()
    {
        $settings = $this->getSettings();
        $linfo = new Linfo($settings);
        $linfo->scan();

        $this->info   = $linfo->getInfo();

        if (!empty($this->info["cpuUsage"]))
        {
            $this->cpu_usage       = TRUE;
            $this->cpu_usage_value = $this->info["cpuUsage"];
        }

        if (
            empty($this->info["Load"]["now"]) AND
            is_string($this->info["Load"]) AND
            strpos($this->info["Load"], "%")
        )
        {
            $this->cpu_usage       = TRUE;
            $this->cpu_usage_value = $this->info["Load"];
        }
    }

    private function createPanelSystemInfo()
    {
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';

        $system = new TDataGridColumn("key", "System", "left", "45%");
        $value  = new TDataGridColumn('value', "", 'left', "55%");

        $this->datagrid->addColumn($system);
        $this->datagrid->addColumn($value);

        $value->setTransformer( function($value, $object, $row) {
            if ($object->key == "Load average") {
                $div = new TElement('span');
                $div->class = "label ";
                $div->class .= ($value > 1) ? "label-danger" : "label-success";
                $div->style="text-shadow:none; font-size:12px";
                $div->add($object->value);
                return $div;
            }
            return $value;
        });

        // creates the datagrid model
        $this->datagrid->createModel();

        // OS
        $item = new StdClass;
        $item->key   = "Operating System";
        $item->value = $this->info["OS"];
        $this->datagrid->addItem($item);

        $distro = "";

        if (!empty($this->info["Distro"]["name"]))
        {
            $distro .= $this->info["Distro"]["name"];
        }

        if (!empty($this->info["Distro"]["version"]))
        {
            $distro .= " " . $this->info["Distro"]["version"];
        }

        // Distribution
        $item = new StdClass;
        $item->key   = "Distribution";
        $item->value =  $distro;
        $this->datagrid->addItem($item);

        // Accessed IP
        $item = new StdClass;
        $item->key   = "Accessed IP";
        $item->value = $this->info["AccessedIP"];
        $this->datagrid->addItem($item);

        $load = '';
        if (!empty($this->info["Load"]["now"]))
        {
            $load = $this->info["Load"]["now"];
        }
        else
        {
            $load = $this->info["Load"];
        }

        // Load
        $item = new StdClass;
        $item->key   = "Load average";
        $item->value = $load;
        $this->datagrid->addItem($item);

        $system_info = new TPanelGroup(mb_strtoupper(_t("System information")));
        $system_info->add($this->datagrid);

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($system_info);
        $a->class .= " col-md-6";
        return $a;
    }

    private function createPanelSystemProcess()
    {
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';

        $key    = new TDataGridColumn("key", "Info", "left", "45%");
        $value  = new TDataGridColumn('value', "", 'left', "55%");

        $this->datagrid->addColumn($key);
        $this->datagrid->addColumn($value);

        // creates the datagrid model
        $this->datagrid->createModel();

        // Uptime
        $item = new StdClass;
        $item->key   = "Uptime";
        $item->value = $this->info["UpTime"]["text"];
        $this->datagrid->addItem($item);

        // HTTP server
        $item = new StdClass;
        $item->key   = "HTTP server";
        $item->value = $this->info["webService"] ?? "";
        $this->datagrid->addItem($item);

        // PHP version
        $item = new StdClass;
        $item->key   = "PHP version";
        $item->value = $this->info["phpVersion"];
        $this->datagrid->addItem($item);

        // Processes
        $item = new StdClass;
        $item->key   = "Process";
        $item->value = $this->info["processStats"]["proc_total"];
        $this->datagrid->addItem($item);

        $system_info = new TPanelGroup(mb_strtoupper(_t("Webserver and Process")));
        $system_info->add($this->datagrid);

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($system_info);
        $a->class .= " col-md-6";
        return $a;
    }

    public function getCpuUsage()
    {
        $this->cpu_usage_value = str_replace("%", "", $this->cpu_usage_value);
        $this->cpu_usage_value = round($this->cpu_usage_value);

        $circle = new THtmlRenderer("app/resources/system_information.html");
        $circle->enableSection("main", ["value" => $this->cpu_usage_value]);

        $span = new TElement("div");
        $span->add($circle->getContents());

        $span->style = "display:flex;";

        $system_info = new TPanelGroup(mb_strtoupper(_t("CPU usage")));
        $system_info->add($span);

        $a = new TElement("div");
        $a->add($system_info);
        $a->style  = "padding: 0 10px;";
        $a->class .= " col-md-4";
        $a->id     = "si_cpu_usage";
        return $a;
    }

    public function getCpuInfo()
    {
        $datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $datagrid->style = 'width: 100%';

        $vendor    = new TDataGridColumn("vendor", _t('Vendor'), "left", "15%");
        $model     = new TDataGridColumn('model', _t('Model'), 'left', "35%");
        $frequency = new TDataGridColumn('frequency', _t('Current Frequency'), 'left', "20%");

        $datagrid->addColumn($vendor);
        $datagrid->addColumn($model);
        $datagrid->addColumn($frequency);

        if ($this->cpu_usage)
        {
            $usage = new TDataGridColumn("usage", _t('Percentage used'), "center", "30%");
            $datagrid->addColumn($usage);

            $usage->setTransformer( function($percent) {

                $percent = round($percent);

                $bar = new TProgressBar;
                $bar->setMask('<b>{value}</b>%');
                $bar->setValue($percent);

                if ($percent <= 30) {
                    $bar->setClass('success');
                }
                else if ($percent <= 50) {
                    $bar->setClass('info');
                }
                else if ($percent <= 85) {
                    $bar->setClass('warning');
                }
                else {
                    $bar->setClass('danger');
                }
                return $bar;
            });
        }


        // creates the datagrid model
        $datagrid->createModel();

        foreach ($this->info["CPU"] as $cpu)
        {

            $item = new StdClass;
            $item->vendor    = $cpu["Vendor"] ?? "";
            $item->model     = $cpu["Model"] ?? "";
            $item->frequency = (array_key_exists('MHz', $cpu) ? ($cpu['MHz'] < 1000 ? $cpu['MHz'].' MHz' : round($cpu['MHz'] / 1000, 3).' GHz') : '');
            $item->usage     = (array_key_exists('usage_percentage', $cpu) ? $cpu['usage_percentage'] : '');

            $datagrid->addItem($item);

        }

        $memory = new TPanelGroup("CPU");
        $memory->add($datagrid);
        // return $memory;

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($memory);
        $a->class .= " col-md-12";
        return $a;
    }

    public function getTemperatureInfo()
    {
        $cards = [];

        foreach ($this->info["Temps"] as $temp)
        {
            if (strpos($temp["name"], "light"))
            {
                continue;
            }

            $card = new TPanelGroup(mb_strtoupper($temp["name"]));
            $card->add($temp["temp"] . " " . $temp["unit"]);

            $a = new TElement("div");
            $a->style = "padding: 0 10px;text-align:center;";
            $a->class .= " col-md-3";
            $a->add($card);

            $cards[] = $a;
        }

        return $cards;
    }

    public function getNetWorkInfo()
    {
        $datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $datagrid->style = 'width: 100%';

        $device_name = new TDataGridColumn("device_name", _t('Device name'), "left", "20%");
        $type        = new TDataGridColumn("type", _t('Type'), "left", "20%");
        $port_speed  = new TDataGridColumn("port_speed", _t('Port speed'), "center", "15%");
        $send        = new TDataGridColumn("send", _t('Sent'), "center", "15%");
        $received    = new TDataGridColumn("received", _t('Recieved'), "center", "15%");
        $status      = new TDataGridColumn("status", _t('Status'), "center", "15%");
        
        $datagrid->addColumn($device_name);
        $datagrid->addColumn($type);
        $datagrid->addColumn($port_speed);
        $datagrid->addColumn($send);
        $datagrid->addColumn($received);
        $datagrid->addColumn($status);
        
        $datagrid->createModel();

        $status->setTransformer( function($value, $object, $row) {
            $div = new TElement('span');
            $div->class = "label ";

            if ($value == "down")
            {
                $div->class .= "label-danger";
            }
            elseif ($value == "up")
            {
                $div->class .= "label-success";
            }
            else
            {
                $div->class .= "label-warning";
            }

            $div->style="text-shadow:none; font-size:12px";
            $div->add($object->status);
            return $div;
        });


        foreach ($this->info["Network Devices"] as $name => $network)
        {
            $item              = new StdClass;
            $item->device_name = $name;
            $item->type        = $network["type"];
            $item->send        = $this->byteConvert($network["sent"]["bytes"]);
            $item->received    = $this->byteConvert($network["recieved"]["bytes"]);
            $item->status      = $network["state"];

            if (empty($network["port_speed"]))
            {
                $item->port_speed = '';
            }
            else
            {
                $item->port_speed = $network["port_speed"] . " Mb/s";
            }

            $datagrid->addItem($item);
        }

        $memory = new TPanelGroup(mb_strtoupper(_t("Network devices")));
        $memory->add($datagrid);
        // return $memory;

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($memory);
        $a->class .= " col-md-12";
        return $a;
    }

    public function getDiskInfo()
    {
        $datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $datagrid->disableHtmlConversion();
        $datagrid->style = 'width: 100%';


        $device       = new TDataGridColumn("device", _t('Device'), "left", "10%");
        $mount_point  = new TDataGridColumn("mount_point", _t('Mount point'), "left", "15%");
        $filesystem   = new TDataGridColumn("filesystem", _t('Filesystem'), "left", "15%");
        $usage        = new TDataGridColumn("usage", _t('Using/Total'), "center", "20%");
        $free         = new TDataGridColumn("free", _t('Free'), "center", "10%");
        $percent_used = new TDataGridColumn("percent_used", _t('Percentage used'), "center", "30%");

        $datagrid->addColumn($device);
        $datagrid->addColumn($mount_point);
        $datagrid->addColumn($filesystem);
        $datagrid->addColumn($usage);
        $datagrid->addColumn($free);
        $datagrid->addColumn($percent_used);

        $percent_used->setTransformer( function($percent) {

            $percent = round($percent);

            $bar = new TProgressBar;
            $bar->setMask('<b>{value}</b>%');
            $bar->setValue($percent);

            if ($percent <= 30) {
                $bar->setClass('success');
            }
            else if ($percent <= 50) {
                $bar->setClass('info');
            }
            else if ($percent <= 85) {
                $bar->setClass('warning');
            }
            else {
                $bar->setClass('danger');
            }
            return $bar;
        });

        // creates the datagrid model
        $datagrid->createModel();

        $done_devices = [];

        foreach ($this->info["Mounts"] as $mount)
        {
            if (!empty($done_devices[$mount["device"]]))
            {
                continue;
            }

            $done_devices[$mount["device"]] = true;

            if (empty($mount["size"]))
            {
                continue;
            }


            $used = $this->byteConvert($mount['used']);

            if ($used == "?")
            {
                continue;
            }

            // $used = explode(" ", $used)[0];
            $total = $this->byteConvert($mount['size']);
            $usage = "<b>{$used}</b>/{$total}";

            $item               = new StdClass;
            $item->device       = $mount["device"];
            $item->mount_point  = $mount["mount"];
            $item->filesystem   = $mount["type"];
            $item->usage        = $usage;
            $item->free         = $this->byteConvert($mount['free']);
            $item->percent_used = $mount["used_percent"];


            $datagrid->addItem($item);

        }

        $memory = new TPanelGroup(mb_strtoupper(_t("Disk devices")));
        $memory->add($datagrid);
        // return $memory;

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($memory);
        $a->class .= " col-md-12";
        return $a;
    }

    public function getMemoryInfo()
    {
        $datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $datagrid->style = 'width: 100%';
        $datagrid->disableHtmlConversion();
        
        $type    = new TDataGridColumn("type", _t('Type'), "left", "15%");
        $use     = new TDataGridColumn("use", _t('Using/Total'), "center", "20%");
        $free    = new TDataGridColumn("free", _t('Free'), "left", "20%");
        $percent = new TDataGridColumn("percent", _t('Percentage used'), "center", "40%");

        $datagrid->addColumn($type);
        $datagrid->addColumn($use);
        $datagrid->addColumn($free);
        $datagrid->addColumn($percent);

        $percent->setTransformer( function($percent) {
            $percent *=100;
            $percent = round($percent);

            $bar = new TProgressBar;
            $bar->setMask('<b>{value}</b>%');
            $bar->setValue($percent);

            if ($percent <= 30) {
                $bar->setClass('success');
            }
            else if ($percent <= 50) {
                $bar->setClass('info');
            }
            else if ($percent <= 85) {
                $bar->setClass('warning');
            }
            else {
                $bar->setClass('danger');
            }
            return $bar;
        });

        // creates the datagrid model
        $datagrid->createModel();

        // add an regular object to the datagrid
        $item = new StdClass;
        $item->type    = $this->info["RAM"]["type"];
        $item->use     = $this->getUsedMemory();
        $item->free    = $this->byteConvert($this->info["RAM"]["free"]);
        $item->percent = ($this->info["RAM"]["total"] -  $this->info["RAM"]["free"]) / $this->info["RAM"]["total"];
        $datagrid->addItem($item);

        $swap = "0/0";
        if (!empty($this->info["RAM"]["swapFree"]))
        {
            $swap = $this->byteConvert($this->info["RAM"]["swapFree"]);
        }

        $item = new StdClass;
        $item->type    = "Swap";
        $item->use     = $this->getUsedSwap();
        $item->free    = $swap;
        if (empty($this->info["RAM"]["swapTotal"]))
        {
            $item->percent = 0;
        }
        else {
            $item->percent = ($this->info["RAM"]["swapTotal"] -  $this->info["RAM"]["swapFree"]) / $this->info["RAM"]["swapTotal"];
        }

        $datagrid->addItem($item);

        $memory = new TPanelGroup(mb_strtoupper(_t("RAM Memory")));
        $memory->add($datagrid);
        // return $memory;

        $a = new TElement("div");
        $a->style = "padding: 0 10px;";
        $a->add($memory);

        if ($this->cpu_usage)
        {
            $a->class .= " col-md-8";
        }
        else
        {
            $a->class .= " col-md-12";
        }
        $a->id = 'si_ram_memory';
        return $a;
    }

    private function getUsedMemory()
    {
        $used = $this->byteConvert($this->info["RAM"]["total"] - $this->info["RAM"]["free"]);
        $used = "<b>" . $used . "</b>";

        return $used . "/ " . $this->byteConvert($this->info["RAM"]["total"]);
    }

    private function getUsedSwap()
    {
        if (empty($this->info["RAM"]["swapTotal"]))
        {
            return '0/0';
        }

        $used = $this->byteConvert($this->info["RAM"]["swapTotal"] - $this->info["RAM"]["swapFree"]);
        $used = "<b>" . $used . "</b>";

        return $used . "/ " . $this->byteConvert($this->info["RAM"]["swapTotal"]);
    }

    public function getSettings()
    {
        // If you experience timezone errors, uncomment (remove //) the following line and change the timezone to your liking
        // date_default_timezone_set('America/New_York');

        /*
        * Usual configuration
        */
        $settings['byte_notation'] = 1024; // Either 1024 or 1000; defaults to 1024
        $settings['dates'] = 'm/d/y h:i A (T)'; // Format for dates shown. See php.net/date for syntax
        $settings['language'] = 'en'; // Refer to the lang/ folder for supported languages
        $settings['icons'] = true; // simple icons
        $settings['theme'] = 'default'; // Theme file (layout/theme_$n.css). Look at the contents of the layout/ folder for other themes.
        $settings['gzip'] = false; // Manually gzip output. Unneeded if your web server already does it.


        $settings['allow_changing_themes'] = false; // Allow changing the theme per user in the UI?

        /*
        * Possibly don't show stuff
        */

        // For certain reasons, some might choose to not display all we can
        // Set these to true to enable; false to disable. They default to false.
        $settings['show']['kernel'] = true;
        $settings['show']['ip'] = true;
        $settings['show']['os'] = true;
        $settings['show']['load'] = true;
        $settings['show']['ram'] = true;
        $settings['show']['hd'] = true;
        $settings['show']['mounts'] = true;
        $settings['show']['mounts_options'] = false; // Might be useless/confidential information; disabled by default.
        $settings['show']['webservice'] = true; // Might be dangerous/confidential information; disabled by default.
        $settings['show']['phpversion'] = true; // Might be dangerous/confidential information; disabled by default.
        $settings['show']['network'] = true;
        $settings['show']['uptime'] = true;
        $settings['show']['cpu'] = true;
        $settings['show']['process_stats'] = true;
        $settings['show']['hostname'] = true;
        $settings['show']['distro'] = true; # Attempt finding name and version of distribution on Linux systems
        $settings['show']['devices'] = true; # Slow on old systems
        $settings['show']['model'] = true; # Model of system. Supported on certain OS's. ex: Macbook Pro
        $settings['show']['numLoggedIn'] = true; # Number of unqiue users with shells running (on Linux)
        $settings['show']['virtualization'] = true; # whether this is a VPS/VM and what kind

        // CPU Usage on Linux (per core and overall). This requires running sleep(1) once so it slows
        // the entire page load down. Enable at your own inconvenience, especially since the load averages
        // are more useful.
        $settings['cpu_usage'] = true;

        // Sometimes a filesystem mount is mounted more than once. Only list the first one I see?
        // (note, duplicates are not shown twice in the file system totals)
        $settings['show']['duplicate_mounts'] = false;

        // Disabled by default as they require extra config below
        $settings['show']['temps'] = true;
        $settings['show']['raid'] = false;

        // Following are probably only useful on laptop/desktop/workstation systems, not servers, although they work just as well
        $settings['show']['battery'] = false;
        $settings['show']['sound'] = false;
        $settings['show']['wifi'] = false; # Not finished

        // Service monitoring
        $settings['show']['services'] = false;

        /*
        * Misc settings pertaining to the above follow below:
        */

        // Hide certain file systems / devices
        $settings['hide']['filesystems'] = array(
            'tmpfs', 'ecryptfs', 'nfsd', 'rpc_pipefs', 'proc', 'sysfs',
            'usbfs', 'devpts', 'fusectl', 'securityfs', 'fuse.truecrypt',
        'cgroup', 'debugfs', 'mqueue', 'hugetlbfs', 'pstore');
        $settings['hide']['storage_devices'] = array('gvfs-fuse-daemon', 'none', 'systemd-1', 'udev');

        // filter mountpoints based on PCRE regex, eg '@^/proc@', '@^/sys@', '@^/dev@'
        $settings['hide']['mountpoints_regex'] = [];

        // Hide mount options for these file systems. (very, very suggested, especially the ecryptfs ones)
        $settings['hide']['fs_mount_options'] = array('ecryptfs');

        // Hide hard drives that begin with /dev/sg?. These are duplicates of usual ones, like /dev/sd?
        $settings['hide']['sg'] = true; # Linux only

        // Set to true to not resolve symlinks in the mountpoint device paths. Eg don't convert /dev/mapper/root to /dev/dm-0
        $settings['hide']['dont_resolve_mountpoint_symlinks'] = false; # Linux only

        // Various softraids. Set to true to enable.
        // Only works if it's available on your system; otherwise does nothing
        $settings['raid']['gmirror'] = false;  # For FreeBSD
        $settings['raid']['mdadm'] = false;  # For Linux; known to support RAID 1, 5, and 6

        // Various ways of getting temps/voltages/etc. Set to true to enable. Currently these are just for Linux
        $settings['temps']['hwmon'] = true; // Requires no extra config, is fast, and is in /sys :)
        $settings['temps']['thermal_zone'] = false;
        $settings['temps']['hddtemp'] = false;
        $settings['temps']['mbmon'] = false;
        $settings['temps']['sensord'] = false; // Part of lm-sensors; logs periodically to syslog. slow
        $settings['temps_show0rpmfans'] = false; // Set to true to show fans with 0 RPM

        // Configuration for getting temps with hddtemp
        $settings['hddtemp']['mode'] = 'daemon'; // Either daemon or syslog
        $settings['hddtemp']['address'] = array( // Address/Port of hddtemp daemon to connect to
            'host' => 'localhost',
            'port' => 7634
        );
        // Configuration for getting temps with mbmon
        $settings['mbmon']['address'] = array( // Address/Port of mbmon daemon to connect to
            'host' => 'localhost',
            'port' => 411
        );

        /*
        * For the things that require executing external programs, such as non-linux OS's
        * and the extensions, you may specify other paths to search for them here:
        */
        $settings['additional_paths'] = array(
            //'/opt/bin' # for example
        );


        /*
        * Services. It works by specifying locations to PID files, which then get checked
        * Either that or specifying a path to the executable, which we'll try to find a running
        * process PID entry for. It'll stop on the first it finds.
        */

        // Format: Label => pid file path
        $settings['services']['pidFiles'] = array(
            // 'Apache' => '/var/run/apache2.pid', // uncomment to enable
            // 'SSHd' => '/var/run/sshd.pid'
        );

        // Format: Label => path to executable or array containing arguments to be checked
        $settings['services']['executables'] = array(
            // 'MySQLd' => '/usr/sbin/mysqld' // uncomment to enable
            // 'BuildSlave' => array('/usr/bin/python', // executable
            //						1 => '/usr/local/bin/buildslave') // argv[1]
        );

        /*
        * Debugging settings
        */

        // Show errors? Disabled by default to hide vulnerabilities / attributes on the server
        $settings['show_errors'] = false;

        // Show results from timing ourselves? Similar to above.
        // Lets you see how much time getting each bit of info takes.
        $settings['timer'] = false;

        // Compress content, can be turned off to view error messages in browser
        $settings['compress_content'] = true;

        /*
        * Occasional sudo
        * Sometimes you may want to have one of the external commands here be ran as root with
        * sudo. This requires the web server user be set to "NOPASS" in your sudoers so the sudo
        * command just works without a prompt.
        *
        * Add names of commands to the array if this is what you want. Just the name of the command;
        * not the complete path. This also applies to commands called by extensions.
        *
        * Note: this is extremely dangerous if done wrong
        */
        $settings['sudo_apps'] = array(
            //'ps' // For example
        );

        $this->settings = $settings;
        return $this->settings;
    }


    // Convert bytes to stuff like KB MB GB TB etc
    public function byteConvert($size, $precision = 2)
    {
        // Sanity check
        if (!is_numeric($size)) {
            return '?';
        }

        // Get the notation
        $notation = $this->settings['byte_notation'] == 1000 ? 1000 : 1024;

        // Fixes large disk size overflow issue
        // Found at http://www.php.net/manual/en/function.disk-free-space.php#81207
        $types = array('B', 'KB', 'MB', 'GB', 'TB');
        $types_i = array('B', 'kB', 'MB', 'GB', 'TB');
        for ($i = 0; $size >= $notation && $i < (count($types) - 1); $size /= $notation, $i++);

        return(round($size, $precision).' '.($notation == 1000 ? $types[$i] : $types_i[$i]));
    }

    public function show()
    {
        parent::show();
        $this->setAlturaUsoCPU();
    }

    public function setAlturaUsoCPU()
    {
        if (!$this->cpu_usage)
        {
            return;
        }

        TScript::create("
        var cpu_usage  = $('#si_cpu_usage .panel');
            var ram_memory = $('#si_ram_memory .panel');
            var max_height = Math.max(ram_memory.height(), cpu_usage.height());

            cpu_usage.height(max_height);
            ram_memory.height(max_height);
        ");
    }
}
