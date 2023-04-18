<?php

namespace App\Controllers;

class Home extends BaseController
{   
    public function __construct() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d");
        $this->db = \Config\Database::connect();
    }
	
	public function login() {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Login']),
			'page_title' => view('partials/page-title', ['title' => 'Login', 'li_1' => 'Welcome to WWP.'])
		];
        
        if (session()->isLoggedIn == TRUE) {
            return redirect()->to('dashboard');
        } else {
            return view('login', $data);
        }
    } 
    
    public function logout() {
		session()->destroy();
		return redirect()->to('/login');
	}
  
    public function postLogin() {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $data = $this->db->query("SELECT * FROM bs_staffs WHERE username = '$username' LIMIT 1")->getResultArray();
        
        if (COUNT($data) > 0){
            $pass = $data[0]['password'];
           
            if ($password == $pass){
                $ses_data = [
                    'staff_id' => $data[0]['id'],
                    'name' => $data[0]['name'],
                    'username' => $data[0]['username'],
                    'role' => $data[0]['role'],
                    'isLoggedIn' => TRUE
                ];
                
                session()->set($ses_data);
                
                switch ($data[0]['role']) {
                    case "0":
                    case "1":
                        return redirect()->to('/dashboard');
                        break;
                    case "2":
                        return redirect()->to('/delivery_order');
                        break;
                }
            }else{
                session()->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        }else{
            session()->setFlashdata('msg', 'Account does not exist.');
            return redirect()->to('/login');
        }
    }
    
    public function profile ()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Profile']),
			'page_title' => view('partials/page-title', ['title' => 'Profile', 'li_1' => 'Pages', 'li_2' => 'Profile'])
		];
		
		return view('profile', $data);
	}
    
    
    
    /////////////////// NOT USED ///////////////////////////////////////////////
	public function show_index_2()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard_2']),
			'page_title' => view('partials/page-title', ['title' => 'Dashboard 2', 'li_1' => 'Dashboard', 'li_2' => 'Dashboard 2'])
		];
		return view('index-2', $data);
	}

	// Vertical Layout Pages Routes
	public function show_layouts_compact_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Compact_Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Compact Sidebar', 'li_1' => 'Layouts', 'li_2' => 'Compact Sidebar'])
		];
		return view('layouts-compact-sidebar', $data);
	}

	public function show_layouts_icon_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Icon_Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Icon Sidebar', 'li_1' => 'Layouts', 'li_2' => 'Icon Sidebar'])
		];
		return view('layouts-icon-sidebar', $data);
	}

	public function show_layouts_boxed()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed_Layout']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed', 'li_1' => 'Layouts', 'li_2' => 'Boxed'])
		];
		return view('layouts-boxed', $data);
	}
	public function show_layouts_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'li_1' => 'Layouts', 'li_2' => 'Preloader'])
		];
		return view('layouts-preloader', $data);
	}

	// Horizontal Layout Pages Routes
	public function show_layouts_horizontal()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Horizontal']),
			'page_title' => view('partials/page-title', ['title' => 'Horizontal', 'li_1' => 'Layouts', 'li_2' => 'Horizontal'])
		];
		return view('layouts-horizontal', $data);
	}

	public function show_layouts_hori_topbarlight()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Topbar_Light']),
			'page_title' => view('partials/page-title', ['title' => 'Topbar Light', 'li_1' => 'Layouts', 'li_2' => 'Topbar Light'])
		];
		return view('layouts-hori-topbarlight', $data);
	}

	public function show_layouts_hori_boxed()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed_Layout']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed', 'li_1' => 'Layouts', 'li_2' => 'Boxed'])
		];
		return view('layouts-hori-boxed', $data);
	}

	public function show_layouts_hori_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'li_1' => 'Layouts', 'li_2' => 'Preloader'])
		];
		return view('layouts-hori-preloader', $data);
	}

	// Calender
	public function show_calendar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Calendar']),
			'page_title' => view('partials/page-title', ['title' => 'Calendar', 'li_1' => 'Calendar'])
		];
		return view('calendar', $data);
	}

	// Email
	public function show_email_inbox()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Inbox']),
			'page_title' => view('partials/page-title', ['title' => 'Inbox', 'li_1' => 'Email', 'li_2' => 'Inbox'])
		];
		return view('email-inbox', $data);
	}
	
	public function show_email_read()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Read_Email']),
			'page_title' => view('partials/page-title', ['title' => 'Read Email', 'li_1' => 'Email', 'li_2' => 'Read Email'])
		];
		return view('email-read', $data);
	}

	// Tasks
	public function show_tasks_list()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Task_List']),
			'page_title' => view('partials/page-title', ['title' => 'Task List', 'li_1' => 'Tasks', 'li_2' => 'Task List'])
		];
		return view('tasks-list', $data);
	}

	public function show_tasks_kanban()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Kanban_Board']),
			'page_title' => view('partials/page-title', ['title' => 'Kanban Board', 'li_1' => 'Tasks', 'li_2' => 'Kanban Board'])
		];
		return view('tasks-kanban', $data);
	}
	public function show_tasks_create()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Create_Task']),
			'page_title' => view('partials/page-title', ['title' => 'Create Task', 'li_1' => 'Tasks', 'li_2' => 'Create Task'])
		];
		return view('tasks-create', $data);
	}

	// Pages
	public function show_pages_register()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Register'])
		];
		return view('pages-register', $data);
	}
	public function show_pages_recoverpw()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Recover_Password'])
		];
		return view('pages-recoverpw', $data);
	}
	public function show_pages_lock_screen()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Lock_Screen'])
		];
		return view('pages-lock-screen', $data);
	}
	public function show_pages_starter()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Starter_Page']),
			'page_title' => view('partials/page-title', ['title' => 'Starter Page', 'li_1' => 'Pages', 'li_2' => 'Starter Page'])
		];
		return view('pages-starter', $data);
	}
	public function show_pages_invoice()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Invoice']),
			'page_title' => view('partials/page-title', ['title' => 'Invoice', 'li_1' => 'Pages', 'li_2' => 'Invoice'])
		];
		return view('pages-invoice', $data);
	}
	public function show_pages_profile()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Profile']),
			'page_title' => view('partials/page-title', ['title' => 'Profile', 'li_1' => 'Pages', 'li_2' => 'Profile'])
		];
		return view('pages-profile', $data);
	}
	public function show_pages_maintenance()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Maintenance'])
		];
		return view('pages-maintenance', $data);
	}
	public function show_pages_comingsoon()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Coming_Soon'])
		];
		return view('pages-comingsoon', $data);
	}
	public function show_pages_timeline()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Timeline']),
			'page_title' => view('partials/page-title', ['title' => 'Timeline', 'li_1' => 'Pages', 'li_2' => 'Timeline'])
		];
		return view('pages-timeline', $data);
	}
	public function show_pages_faqs()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'FAQs']),
			'page_title' => view('partials/page-title', ['title' => 'FAQS', 'li_1' => 'Pages', 'li_2' => 'FAQS'])
		];
		return view('pages-faqs', $data);
	}
	public function show_pages_pricing()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Pricing']),
			'page_title' => view('partials/page-title', ['title' => 'Pricing', 'li_1' => 'Pages', 'li_2' => 'Pricing'])
		];
		return view('pages-pricing', $data);
	}
	public function show_pages_404()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Error_404'])
		];
		return view('pages-404', $data);
	}
	public function show_pages_500()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Error_500'])
		];
		return view('pages-500', $data);
	}

	// UI Elements
	public function show_ui_alerts()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Alerts']),
			'page_title' => view('partials/page-title', ['title' => 'Alerts', 'li_1' => 'UI Elements', 'li_2' => 'Alerts'])
		];
		return view('ui-alerts', $data);
	}
	public function show_ui_buttons()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Buttons']),
			'page_title' => view('partials/page-title', ['title' => 'Buttons', 'li_1' => 'UI Elements', 'li_2' => 'Buttons'])
		];
		return view('ui-buttons', $data);
	}
	public function show_ui_cards()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Cards']),
			'page_title' => view('partials/page-title', ['title' => 'Cards', 'li_1' => 'UI Elements', 'li_2' => 'Cards'])
		];
		return view('ui-cards', $data);
	}
	public function show_ui_carousel()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Carousel']),
			'page_title' => view('partials/page-title', ['title' => 'Carousel', 'li_1' => 'UI Elements', 'li_2' => 'Carousel'])
		];
		return view('ui-carousel', $data);
	}
	public function show_ui_dropdowns()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dropdowns']),
			'page_title' => view('partials/page-title', ['title' => 'Dropdowns', 'li_1' => 'UI Elements', 'li_2' => 'Dropdowns'])
		];
		return view('ui-dropdowns', $data);
	}
	public function show_ui_grid()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Grid']),
			'page_title' => view('partials/page-title', ['title' => 'Grid', 'li_1' => 'UI Elements', 'li_2' => 'Grid'])
		];
		return view('ui-grid', $data);
	}
	public function show_ui_images()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Images']),
			'page_title' => view('partials/page-title', ['title' => 'Images', 'li_1' => 'UI Elements', 'li_2' => 'Images'])
		];
		return view('ui-images', $data);
	}
	public function show_ui_lightbox()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Lightbox']),
			'page_title' => view('partials/page-title', ['title' => 'Lightbox', 'li_1' => 'UI Elements', 'li_2' => 'Lightbox'])
		];
		return view('ui-lightbox', $data);
	}
	public function show_ui_modals()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Modals']),
			'page_title' => view('partials/page-title', ['title' => 'Modals', 'li_1' => 'UI Elements', 'li_2' => 'Modals'])
		];
		return view('ui-modals', $data);
	}
	public function show_ui_rangeslider()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Range_Slider']),
			'page_title' => view('partials/page-title', ['title' => 'Range Slider', 'li_1' => 'UI Elements', 'li_2' => 'Range Slider'])
		];
		return view('ui-rangeslider', $data);
	}
	public function show_ui_session_timeout()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Session_Timeout']),
			'page_title' => view('partials/page-title', ['title' => 'Session Timeout', 'li_1' => 'UI Elements', 'li_2' => 'Session Timeout'])
		];
		return view('ui-session-timeout', $data);
	}
	public function show_ui_progressbars()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Progress_Bars']),
			'page_title' => view('partials/page-title', ['title' => 'Progress Bars', 'li_1' => 'UI Elements', 'li_2' => 'Progress Bars'])
		];
		return view('ui-progressbars', $data);
	}
	public function show_ui_sweet_alert()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Sweet_Alert']),
			'page_title' => view('partials/page-title', ['title' => 'SweetAlert 2', 'li_1' => 'UI Elements', 'li_2' => 'SweetAlert 2'])
		];
		return view('ui-sweet-alert', $data);
	}
	public function show_ui_tabs_accordions()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Tabs_and_Accordions']),
			'page_title' => view('partials/page-title', ['title' => 'Tabs & Accordions', 'li_1' => 'UI Elements', 'li_2' => 'Tabs & Accordions'])
		];
		return view('ui-tabs-accordions', $data);
	}
	public function show_ui_typography()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Typography']),
			'page_title' => view('partials/page-title', ['title' => 'Typography', 'li_1' => 'UI Elements', 'li_2' => 'Typography'])
		];
		return view('ui-typography', $data);
	}
	public function show_ui_video()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Video']),
			'page_title' => view('partials/page-title', ['title' => 'Video', 'li_1' => 'UI Elements', 'li_2' => 'Video'])
		];
		return view('ui-video', $data);
	}
	public function show_ui_general()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'General']),
			'page_title' => view('partials/page-title', ['title' => 'General UI', 'li_1' => 'UI Elements', 'li_2' => 'General UI'])
		];
		return view('ui-general', $data);
	}
	public function show_ui_colors()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Colors']),
			'page_title' => view('partials/page-title', ['title' => 'Colors', 'li_1' => 'UI Elements', 'li_2' => 'Colors'])
		];
		return view('ui-colors', $data);
	}
	public function show_ui_rating()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Rating']),
			'page_title' => view('partials/page-title', ['title' => 'Rating', 'li_1' => 'UI Elements', 'li_2' => 'Rating'])
		];
		return view('ui-rating', $data);
	}

	// Forms
	public function show_form_elements()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Elements']),
			'page_title' => view('partials/page-title', ['title' => 'Form Elements', 'li_1' => 'Forms', 'li_2' => 'Form Elements'])
		];
		return view('form-elements', $data);
	}
	public function show_form_validation()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Validation']),
			'page_title' => view('partials/page-title', ['title' => 'Form Validation', 'li_1' => 'Forms', 'li_2' => 'Form Validation'])
		];
		return view('form-validation', $data);
	}
	public function show_form_advanced()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Advanced']),
			'page_title' => view('partials/page-title', ['title' => 'Form Advanced', 'li_1' => 'Forms', 'li_2' => 'Form Advanced'])
		];
		return view('form-advanced', $data);
	}
	public function show_form_editors()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Editors']),
			'page_title' => view('partials/page-title', ['title' => 'Form Editors', 'li_1' => 'Forms', 'li_2' => 'Form Editors'])
		];
		return view('form-editors', $data);
	}
	public function show_form_uploads()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_File_Upload']),
			'page_title' => view('partials/page-title', ['title' => 'Form File Upload', 'li_1' => 'Forms', 'li_2' => 'Form File Upload'])
		];
		return view('form-uploads', $data);
	}
	public function show_form_xeditable()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Xeditable']),
			'page_title' => view('partials/page-title', ['title' => 'Form Xeditable', 'li_1' => 'Forms', 'li_2' => 'Form Xeditable'])
		];
		return view('form-xeditable', $data);
	}
	public function show_form_repeater()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Repeater']),
			'page_title' => view('partials/page-title', ['title' => 'Form Repeater', 'li_1' => 'Forms', 'li_2' => 'Form Repeater'])
		];
		return view('form-repeater', $data);
	}
	public function show_form_wizard()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Wizard']),
			'page_title' => view('partials/page-title', ['title' => 'Form Wizard', 'li_1' => 'Forms', 'li_2' => 'Form Wizard'])
		];
		return view('form-wizard', $data);
	}
	public function show_form_mask()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Form_Mask']),
			'page_title' => view('partials/page-title', ['title' => 'Form Mask', 'li_1' => 'Forms', 'li_2' => 'Form Mask'])
		];
		return view('form-mask', $data);
	}

	// Tables
	public function show_tables_basic()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Basic_Tables']),
			'page_title' => view('partials/page-title', ['title' => 'Basic Tables', 'li_1' => 'Tables', 'li_2' => 'Basic Tables'])
		];
		return view('tables-basic', $data);
	}
	public function show_tables_datatable()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Data_Tables']),
			'page_title' => view('partials/page-title', ['title' => 'Data Tables', 'li_1' => 'Tables', 'li_2' => 'Data Tables'])
		];
		return view('tables-datatable', $data);
	}
	public function show_tables_responsive()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Responsive_Table']),
			'page_title' => view('partials/page-title', ['title' => 'Responsive Table', 'li_1' => 'Tables', 'li_2' => 'Responsive Table'])
		];
		return view('tables-responsive', $data);
	}
	public function show_tables_editable()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Editable_Table']),
			'page_title' => view('partials/page-title', ['title' => 'Editable Table', 'li_1' => 'Tables', 'li_2' => 'Editable Table'])
		];
		return view('tables-editable', $data);
	}

	// Charts
	public function show_charts_apex()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Apex_charts']),
			'page_title' => view('partials/page-title', ['title' => 'Apex charts', 'li_1' => 'Charts', 'li_2' => 'Apex charts'])
		];
		return view('charts-apex', $data);
	}
	public function show_charts_chartjs()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Chartjs_Chart']),
			'page_title' => view('partials/page-title', ['title' => 'Chartjs', 'li_1' => 'Charts', 'li_2' => 'Chartjs'])
		];
		return view('charts-chartjs', $data);
	}
	public function show_charts_flot()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Flot_Chart']),
			'page_title' => view('partials/page-title', ['title' => 'Flot charts', 'li_1' => 'Charts', 'li_2' => 'Flot charts'])
		];
		return view('charts-flot', $data);
	}
	public function show_charts_knob()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Jquery_Knob_Chart']),
			'page_title' => view('partials/page-title', ['title' => 'Jquery Knob Chart', 'li_1' => 'Charts', 'li_2' => 'Jquery Knob Chart'])
		];
		return view('charts-knob', $data);
	}
	public function show_charts_sparkline()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Sparkline_Chart']),
			'page_title' => view('partials/page-title', ['title' => 'Sparkline chart', 'li_1' => 'Charts', 'li_2' => 'Sparkline chart'])
		];
		return view('charts-sparkline', $data);
	}

	// Icons
	public function show_icons_boxicons()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxicons']),
			'page_title' => view('partials/page-title', ['title' => 'Boxicons', 'li_1' => 'Icons', 'li_2' => 'Boxicons'])
		];
		return view('icons-boxicons', $data);
	}
	public function show_icons_materialdesign()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Material_Design']),
			'page_title' => view('partials/page-title', ['title' => 'Material Design', 'li_1' => 'Icons', 'li_2' => 'Material Design'])
		];
		return view('icons-materialdesign', $data);
	}
	public function show_icons_dripicons()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dripicons']),
			'page_title' => view('partials/page-title', ['title' => 'Dripicons', 'li_1' => 'Icons', 'li_2' => 'Dripicons'])
		];
		return view('icons-dripicons', $data);
	}
	public function show_icons_fontawesome()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Font_awesome']),
			'page_title' => view('partials/page-title', ['title' => 'Font Awesome', 'li_1' => 'Icons', 'li_2' => 'Font Awesome'])
		];
		return view('icons-fontawesome', $data);
	}

	// Maps
	public function show_maps_google()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Google_Maps']),
			'page_title' => view('partials/page-title', ['title' => 'Google Maps', 'li_1' => 'Maps', 'li_2' => 'Google Maps'])
		];
		return view('maps-google', $data);
	}
	public function show_maps_vector()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Vector_Maps']),
			'page_title' => view('partials/page-title', ['title' => 'Vector Maps', 'li_1' => 'Maps', 'li_2' => 'Vector Maps'])
		];
		return view('maps-vector', $data);
	}

}
