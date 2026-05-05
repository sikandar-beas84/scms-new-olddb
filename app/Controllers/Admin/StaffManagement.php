<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SessionYearModel;
use App\Models\DesignationModel;
use App\Models\AdminUserModel;
use App\Models\DeptModel;

class StaffManagement extends BaseController
{
    /**
     * Displays the Designation management page.
     *
     * Loads the header, topbar, sidebar, designation list view, and footer
     * to render the Designation management section in the admin panel.
     *
     * ## Usage
     *
     * This method is typically accessed via the route associated with
     * "admin/staff-management/designation". It prepares the `$data` array
     * with the required page title and passes it to the views.
     *
     * ## Views Loaded
     *
     * - admin/common/header
     * - admin/common/topbar
     * - admin/common/sidebar
     * - admin/staff-management/designation/list
     * - admin/common/footer
     *
     * ## Notes
     *
     * - `$data['title']` is set to `"Designation"`.
     * - If you need to fetch designations from the database, you can
     *   uncomment the `$designationModel` lines to query and pass them
     *   into the `list` view.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  void  Outputs the rendered Designation management page.
     */
	public function index()
    {
        $data['title'] = "Designation";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        // $designationModel = new DesignationModel();
        // $data['designation'] = $designationModel->orderBy('id', 'DESC')->findAll();
        echo view('admin/staff-management/designation/list', $data);  

        echo view('admin/common/footer', $data);
    }

    /**
     * Fetches all designations from the database.
     *
     * Retrieves the list of designations ordered by their ID in descending order
     * and returns the results as a JSON response. This method is useful for
     * AJAX requests or API endpoints where designation data needs to be consumed
     * in JSON format.
     *
     * ## Usage
     *
     * Typically called via an AJAX request from the admin panel. Example:
     *
     * ```javascript
     * $.get(base_url + "/admin/staff-management/fetch-designation", function(response) {
     *     console.log(response.designation);
     * });
     * ```
     *
     * ## Response
     *
     * Returns a JSON object in the following format:
     *
     * ```json
     * {
     *   "designation": [
     *     {
     *       "id": 1,
     *       "title": "Manager",
     *       "created_at": "2025-08-31 12:00:00"
     *     },
     *     {
     *       "id": 2,
     *       "title": "Supervisor",
     *       "created_at": "2025-08-31 12:30:00"
     *     }
     *   ]
     * }
     * ```
     *
     * ## Notes
     *
     * - Uses `DesignationModel` to interact with the `designation` table.
     * - The data is always ordered by `id` in descending order.
     * - Designed for asynchronous calls; it does not render a view.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response  JSON response containing the list of designations.
     */
    public function fetch_designation()
    {
        $designationModel = new DesignationModel();
        $designation = $designationModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON(['designation' => $designation]);
    }

    /**
     * Retrieves a single designation by its ID.
     *
     * Accepts a designation ID via POST request, queries the database,
     * and returns the corresponding designation record in JSON format.
     * This method is commonly used for editing or viewing a specific
     * designation record through AJAX requests in the admin panel.
     *
     * ## Usage
     *
     * Example AJAX call using jQuery:
     *
     * ```javascript
     * $.post(base_url + "/admin/staff-management/get-designation", { id: 5 }, function(response) {
     *     if (response.status === "success") {
     *         console.log(response.designation);
     *     }
     * });
     * ```
     *
     * ## Response
     *
     * Returns a JSON object in the following format:
     *
     * ```json
     * {
     *   "status": "success",
     *   "designation": {
     *     "id": 5,
     *     "title": "Team Lead",
     *     "created_at": "2025-08-31 14:15:00"
     *   }
     * }
     * ```
     *
     * ## Notes
     *
     * - The `id` parameter must be provided in the POST request.
     * - Uses `DesignationModel` to fetch the record.
     * - Returns only the first matching record (`->first()`).
     * - Response includes a `status` key to indicate success.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response  JSON response containing a single designation record.
     */
    public function get_designation() {
        $id = $this->request->getPost('id');

        $designationModel = new DesignationModel();
        $designation = $designationModel->where('id', $id)->first();

        return $this->response->setJSON(['status' => 'success', 'designation' => $designation]);
    }

    /**
     * Creates or updates a designation record.
     *
     * Handles both insertion of a new designation and updating of an
     * existing designation, depending on whether an `id` is provided
     * in the POST request. Returns a JSON response with operation status
     * and an appropriate message.
     *
     * ## Usage
     *
     * Example AJAX call to add a designation:
     *
     * ```javascript
     * $.post(base_url + "/admin/staff-management/save-designation", {
     *     name: "Project Manager",
     *     status: true
     * }, function(response) {
     *     console.log(response.message);
     * });
     * ```
     *
     * Example AJAX call to update a designation:
     *
     * ```javascript
     * $.post(base_url + "/admin/staff-management/save-designation", {
     *     id: 3,
     *     name: "Senior Developer",
     *     status: false
     * }, function(response) {
     *     console.log(response.message);
     * });
     * ```
     *
     * ## Response
     *
     * Success (insert):
     * ```json
     * {
     *   "status": "success",
     *   "message": "Designation added successfully."
     * }
     * ```
     *
     * Success (update):
     * ```json
     * {
     *   "status": "success",
     *   "message": "Designation updated successfully."
     * }
     * ```
     *
     * Error (validation failure):
     * ```json
     * {
     *   "status": "error",
     *   "message": "All fields are required."
     * }
     * ```
     *
     * Error (invalid method):
     * ```json
     * {
     *   "status": "error",
     *   "message": "Invalid request method."
     * }
     * ```
     *
     * ## Notes
     *
     * - Only accepts `POST` requests.
     * - Expects the following fields in the request body:
     *   - `id` (optional, integer) → for updating an existing record.
     *   - `name` (string, required) → designation name.
     *   - `status` (boolean, required) → designation status (active/inactive).
     * - Uses `DesignationModel` for database operations.
     * - Performs basic validation to ensure required fields are present.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response  JSON response indicating success or error.
     */
    public function save_designation()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }

        $designationModel = new DesignationModel();

        $id = $this->request->getPost('id');
        $name = trim($this->request->getPost('name'));
        $status   = trim($this->request->getPost('status'));
        
        // Basic validation
        if ($name === '' || $status === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

        $data = [
            'name' => $name,
            'status'   => filter_var($status, FILTER_VALIDATE_BOOLEAN),
        ];

        if ($id) {
            // UPDATE
            if ($designationModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Designation updated successfully.'
                ]);
            }
        } else {
            // INSERT
            if ($designationModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Designation added successfully.'
                ]);
            }
        }

        // If failed
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Database operation failed.'
        ]);
    }

    /**
     * Changes the status of a designation.
     *
     * Updates the `status` field of a given designation record based on
     * the provided ID and status value. This method is typically called
     * via AJAX when toggling a designation's active/inactive state in
     * the admin panel.
     *
     * ## Usage
     *
     * Example AJAX call using jQuery:
     *
     * ```javascript
     * $.post(base_url + "/admin/staff-management/change-designation-status", {
     *     id: 7,
     *     status: false
     * }, function(response) {
     *     if (response.status === "success") {
     *         console.log("Status updated successfully");
     *     }
     * });
     * ```
     *
     * ## Response
     *
     * On success:
     * ```json
     * {
     *   "status": "success"
     * }
     * ```
     *
     * ## Notes
     *
     * - Expects `id` (integer) and `status` (boolean or integer) in the POST request.
     * - Uses `DesignationModel::update()` to apply the change.
     * - Does not perform validation; assumes both parameters are valid.
     * - Designed for quick status toggling (e.g., enable/disable a designation).
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response  JSON response indicating success.
     */
    public function change_designation_status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $designationModel = new DesignationModel();
        $designationModel->update($id, ['status' => $status]);

        return $this->response->setJSON(['status' => 'success']);
    }

    /**
     * Displays the Admin Members management page.
     *
     * Loads all required views and passes necessary data (session years
     * and admin users) to render the Admin Members list in the admin panel.
     *
     * ## Usage
     *
     * Accessed through the admin route associated with
     * `"admin/staff-management/admin-members"`. It prepares the data array
     * containing the page title, available session years, and all admin users,
     * then loads the appropriate view files.
     *
     * ## Views Loaded
     *
     * - `admin/common/header`
     * - `admin/common/topbar`
     * - `admin/common/sidebar`
     * - `admin/staff-management/admin-members/list`
     * - `admin/common/footer`
     *
     * ## Data Passed to Views
     *
     * - `$title` → `"Admin Members"`.
     * - `$session_year` → All session years ordered by ID (DESC),
     *   retrieved using `SessionYearModel`.
     * - `$all_users` → All admin users, retrieved using
     *   `AdminUserModel::get_all_users()`.
     *
     * ## Notes
     *
     * - Intended for rendering the **list page** of admin members.
     * - Relies on `SessionYearModel` for session year data.
     * - Relies on `AdminUserModel` for user data.
     * - No JSON response; this method is strictly for rendering views.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  void  Outputs the rendered Admin Members management page.
     */
    public function admin_members()
    {
        $data['title'] = "Admin Members";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $sessionYearModel = new SessionYearModel();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'DESC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['all_users'] = $adminUserModel->get_all_users();
        // print_r($data); die();
        echo view('admin/staff-management/admin-members/list', $data);  

        echo view('admin/common/footer', $data);
    }

    /**
     * Displays the Add Admin Members form page.
     *
     * Prepares and loads all required views and data for rendering the
     * "Add Admin Members" form in the admin panel. This includes
     * designation and department lists to populate dropdowns in the form.
     *
     * ## Usage
     *
     * Accessed through the admin route associated with
     * `"admin/staff-management/admin-members/add"`. It prepares the
     * `$data` array with the page title, available designations,
     * and available departments, then loads the appropriate views.
     *
     * ## Views Loaded
     *
     * - `admin/common/header`
     * - `admin/common/topbar`
     * - `admin/common/sidebar`
     * - `admin/staff-management/admin-members/add`
     * - `admin/common/footer`
     *
     * ## Data Passed to Views
     *
     * - `$title` → `"Add Admin Members"`.
     * - `$designation_list` → All designations ordered by ID (ASC),
     *   retrieved using `DesignationModel`.
     * - `$dept_list` → All departments ordered by ID (ASC),
     *   retrieved using `DeptModel`.
     *
     * ## Notes
     *
     * - Intended for rendering the **Add Admin Members form page**.
     * - Relies on `DesignationModel` and `DeptModel` to fetch
     *   dropdown data.
     * - Example conditional code for different admin roles is present
     *   but commented out.
     * - This method renders views only; it does not handle form submission.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  void  Outputs the rendered Add Admin Members form page.
     */
    public function add_admin_members()
    {
        $data['title'] = "Add Admin Members";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $designationModel = new DesignationModel();
        $data['designation_list'] = $designationModel->orderBy('id', 'ASC')->findAll();

        $deptModel = new DeptModel();
        $data['dept_list'] = $deptModel->orderBy('id', 'ASC')->findAll();

        // if($this->session->userdata('specialadmin_logged_in') == true){
        //     $data['dept_list'] =  $this->master_model->get_all_list('dept');
        // } else {
        //     $data['dept_list'] =  $this->master_model->get_dept_excluded_list('dept');
        // }

        echo view('admin/staff-management/admin-members/add', $data);
        echo view('admin/common/footer', $data);
    }

    /**
     * Displays the Edit Admin Members form page.
     *
     * Loads all required views and data to render the edit form for an
     * existing admin member in the admin panel. If no valid ID is provided,
     * the method redirects back to the admin members list page.
     *
     * ## Usage
     *
     * Accessed through the admin route associated with
     * `"admin/staff-management/admin-members/edit/{id}"`. It prepares
     * the `$data` array with the page title, available designations,
     * available departments, and the admin user record to be edited.
     *
     * ## Views Loaded
     *
     * - `admin/common/header`
     * - `admin/common/topbar`
     * - `admin/common/sidebar`
     * - `admin/staff-management/admin-members/edit`
     * - `admin/common/footer`
     *
     * ## Data Passed to Views
     *
     * - `$title` → `"Edit Admin Members"`.
     * - `$designation_list` → All designations ordered by ID (ASC),
     *   retrieved using `DesignationModel`.
     * - `$dept_list` → All departments ordered by ID (ASC),
     *   retrieved using `DeptModel`.
     * - `$user` → Admin user record fetched by the provided `$id`,
     *   retrieved using `AdminUserModel`.
     *
     * ## Notes
     *
     * - If `$id` is missing or invalid, the user is redirected back to
     *   `"admin/staff-management/admin-members/"`.
     * - Relies on `DesignationModel`, `DeptModel`, and `AdminUserModel`
     *   for fetching form data.
     * - Contains commented-out code showing how to load different department
     *   lists based on admin roles.
     * - This method only renders the form; it does not handle form submission.
     *
     * @since   1.0.0
     * @access  public
     *
     * @param   int|string  $id  The ID of the admin member to edit.
     * @return  \CodeIgniter\HTTP\RedirectResponse|void
     *          Redirects to the members list if no ID is provided,
     *          otherwise outputs the rendered edit form page.
     */
    public function edit_admin_members($id)
    {
        if (!isset($id) || !$id) {
            return redirect()->to('admin/staff-management/admin-members/'); 
        }

        $data['title'] = "Edit Admin Members";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);

        $designationModel = new DesignationModel();
        $data['designation_list'] = $designationModel->orderBy('id', 'ASC')->findAll();

        $deptModel = new DeptModel();
        $data['dept_list'] = $deptModel->orderBy('id', 'ASC')->findAll();

        $adminUserModel = new AdminUserModel();
        $data['user'] = $adminUserModel->where('id', $id)->first();

        // if($this->session->userdata('specialadmin_logged_in') == true){
        //     $data['dept_list'] =  $this->master_model->get_all_list('dept');
        // } else {
        //     $data['dept_list'] =  $this->master_model->get_dept_excluded_list('dept');
        // }
        // echo"<pre>"; print_r($data); die();
        
        echo view('admin/staff-management/admin-members/edit', $data);
        echo view('admin/common/footer', $data);
    }

    /**
     * Fetch all admin members (AJAX).
     *
     * Retrieves the complete list of admin users from the database
     * using the `AdminUserModel::get_all_users()` method and returns
     * the results as a JSON response. This method is typically called
     * via AJAX to dynamically populate data tables or UI components
     * without requiring a full page reload.
     *
     * ## Usage
     *
     * - Triggered by an AJAX request to the endpoint
     *   `"admin/staff-management/fetch-admin-members"`.
     * - Returns a JSON response containing all users.
     *
     * ## Response Format
     *
     * ```json
     * {
     *   "users": [
     *     {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "designation": "Manager",
     *       "status": 1,
     *       ...
     *     },
     *     ...
     *   ]
     * }
     * ```
     *
     * ## Notes
     *
     * - Relies on a custom model method `get_all_users()` in
     *   `AdminUserModel` to retrieve user records.
     * - Does not load any views — response is strictly JSON.
     * - Designed for use in JavaScript DataTables, grids,
     *   or other dynamic UI elements.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response
     *          JSON response containing the list of admin members.
     */
    public function fetch_admin_members()
    {
        $adminUserModel = new AdminUserModel();
        $all_users = $adminUserModel->get_all_users();

        return $this->response->setJSON(['users' => $all_users]);
    }

    /**
     * Save a new admin member.
     *
     * Handles form submission for adding a new admin member. This method:
     *
     * 1. Validates all required input fields, including password,
     *    confirmation, unique code, and user details.
     * 2. Collects all form data (personal, academic, and professional info).
     * 3. Hashes the password securely before saving.
     * 4. Uploads and stores the profile image (if provided) into a
     *    dedicated folder: `uploads/{studentCode}`.
     * 5. Inserts the user record into the `admin_users` table using
     *    `AdminUserModel`.
     *
     * ## Validation Rules
     *
     * - **user_id**: required
     * - **first_name**, **last_name**: required
     * - **password**: required, min length 6
     * - **password_confirm**: required, matches `password`
     * - **code**: required, unique in `admin_users.code`
     * - **designation_id**, **user_type**: required
     *
     * ## File Upload
     *
     * - Expects a file input named `pro_image`.
     * - Stores in `/uploads/{studentCode}/`.
     * - Auto-creates the directory if it doesn’t exist.
     * - Renames file safely to avoid conflicts.
     *
     * ## Response Format
     *
     * On success:
     * ```json
     * {
     *   "status": "success",
     *   "message": "User added successfully."
     * }
     * ```
     *
     * On failure (validation, upload, or DB error):
     * ```json
     * {
     *   "status": "error",
     *   "message": "User creation failed"
     * }
     * ```
     *
     * ## Notes
     *
     * - Passwords are stored using `password_hash()` for security.
     * - Profile images are optional but handled if uploaded.
     * - Session year ID is pulled from `$this->session->get('session_year_id')`.
     * - Designed to be called via AJAX form submission.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response
     *          JSON response with operation status and message.
     */
    public function save_admin_members()
    {
        $adminUserModel = new AdminUserModel();

        $rules = [
            'user_id'           => 'required',
            'first_name'        => 'required',
            'last_name'         => 'required',
            'password'          => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[6]'
            ],
            'password_confirm'  => [
                'label'  => 'Confirm Password',
                'rules'  => 'required|min_length[6]|matches[password]'
            ],
            'code' => [
                'label' => 'Code',
                'rules' => 'required|is_unique[admin_users.code]',
                'errors' => [
                    'required'   => 'The {field} is required.',
                    'is_unique'  => 'This {field} already exists in admin_users.',
                ],
            ],
            'designation_id'    => 'required',
            'user_type'    => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $validation->getErrors()
            ]);
        }
        
        // Validation passed, process the form data

        $user_id          = $this->request->getPost('user_id') ?: null;
        $first_name       = $this->request->getPost('first_name') ?: null;
        $last_name        = $this->request->getPost('last_name') ?: null;
        $password         = $this->request->getPost('password') ?: null;
        $password_confirm = $this->request->getPost('password_confirm') ?: null;
        $studentCode      = $this->request->getPost('code') ?: null;
        $user_type        = $this->request->getPost('user_type') ?: null;
        $designation_id   = $this->request->getPost('designation_id') ?: null;
        $pancard_number   = $this->request->getPost('pancard_number') ?: null;
        $address          = $this->request->getPost('address') ?: null;
        $present_address  = $this->request->getPost('present_address') ?: null;
        $aadhar_number    = $this->request->getPost('aadhar_number') ?: null;
        $phone_no_other   = $this->request->getPost('phone_no_other') ?: null;
        $bank_name        = $this->request->getPost('bank_name') ?: null;
        $bank_acc_number  = $this->request->getPost('bank_acc_number') ?: null;
        $bank_ifsc_number = $this->request->getPost('bank_ifsc_number') ?: null;
        $esic_number      = $this->request->getPost('esic_number') ?: null;
        $pf_number        = $this->request->getPost('pf_number') ?: null;
        $oasis_id         = $this->request->getPost('oasis_id') ?: null;
        $spouse_name      = $this->request->getPost('spouse_name') ?: null;
        $joining_date     = $this->request->getPost('joining_date') ?: null;   // NULL if empty
        $subject_tought   = $this->request->getPost('subject_tought') ?: null;
        $class_taken      = $this->request->getPost('class_taken') ?: null;
        $state            = $this->request->getPost('state') ?: null;
        $pincode          = $this->request->getPost('pincode') ?: null;
        $country          = $this->request->getPost('country') ?: null;
        $city             = $this->request->getPost('city') ?: null;
        $qualification    = $this->request->getPost('qualification') ?: null;
        $extra_qualification = $this->request->getPost('extra_qualification') ?: null;
        $experience       = $this->request->getPost('experience') ?: null;
        $mobile           = $this->request->getPost('mobile') ?: null;
        $emaill           = $this->request->getPost('emaill') ?: null;
        $date_of_birth    = $this->request->getPost('date_of_birth') ?: null; // NULL if empty
        $gender           = $this->request->getPost('gender') ?: null;
        $status           = $this->request->getPost('status') ?: null;
        $user_email       = $this->request->getPost('user_email') ?: null;

        $user_data = [
            'email'               => $user_id,
            'created_date'        => date('Y-m-d H:i:s'),
            'first_name'          => $first_name,
            'last_name'           => $last_name,
            'password'            => password_hash($password, PASSWORD_DEFAULT),
            'code'                => $studentCode,
            'mobile'              => $mobile,
            'gender'              => $gender,
            'dept_id'             => (int) $user_type,
            'designation_id'      => (int) $designation_id,
            'session_id'          => (int) $this->session->get('session_year_id'),
            'address'             => $address,
            'city'                => $city,
            'state'               => $state,
            'pincode'             => $pincode,
            'country'             => $country,
            'qualification'       => $qualification,
            'extra_qualification' => $extra_qualification,
            'experience'          => $experience,
            'date_of_birth'       => $date_of_birth,
            'present_address'     => $present_address,
            'pancard_number'      => strtoupper($pancard_number),
            'aadhar_number'       => strtoupper($aadhar_number),
            'phone_no_other'      => $phone_no_other,
            'bank_name'           => $bank_name,
            'bank_acc_number'     => $bank_acc_number,
            'bank_ifsc_number'    => strtoupper($bank_ifsc_number),
            'esic_number'         => $esic_number,
            'pf_number'           => strtoupper($pf_number),
            'useremaill'          => $user_email,
            'oasis_id'            => $oasis_id,
            'spouse_name'         => $spouse_name,
            'emaill'              => $emaill,
            'joining_date'        => $joining_date,
            'subject_tought'      => $subject_tought,
            'class_taken'         => $class_taken,
            'status'              => $status,
        ];

        $file = $this->request->getFile('pro_image');
        
        if ($file->getName() != '') {
            // 3) Build target path: writable/uploads/students/{studentCode}
            $basePath = FCPATH . 'uploads';
            $targetPath = $basePath . DIRECTORY_SEPARATOR . $studentCode;

            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true); // recursive, with permissions
                // return "Directory created: " . $path;
            } else {
                // return "Directory already exists: " . $path;
            }
            
            if (! is_dir($targetPath)) {
                if (! mkdir($targetPath, 0775, true)) {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => 'Failed to create destination folder.'
                    ]);
                }
            }

            // 4) Choose a safe filename (keep original, but avoid collisions)
            $originalName = $file->getClientName();
            $safeName = preg_replace('~[^A-Za-z0-9_.\-]~', '_', $originalName);
            $destination = $studentCode . DIRECTORY_SEPARATOR . $safeName;


            if (file_exists($destination)) {
                $nameNoExt = pathinfo($safeName, PATHINFO_FILENAME);
                $ext = $file->getExtension();
                $safeName = $nameNoExt . '_' . date('Ymd_His') . '.' . $ext;
            }

            // 5) Move the file
            try {
                $file->move($targetPath, $safeName, true);
            } catch (\Throwable $e) {
                // return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]);
            }

            $user_data['image'] = $safeName;
        }

        // echo "<pre>"; print_r($user_data); die();
        
        // 6) Save uploaded file details into DB
        if ($adminUserModel->insert($user_data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User added successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'User creation failed'
        ]);
    }

    /**
     * Update an existing admin member.
     *
     * Handles form submission for editing an existing admin member’s details.
     * This method:
     *
     * 1. Validates required input fields (first name, last name,
     *    designation, and user type).
     * 2. Checks if the user exists in the database before proceeding.
     * 3. Collects all editable fields (personal, academic, professional info).
     * 4. Handles optional profile image upload, saving it into a dedicated
     *    folder: `uploads/{code}` (auto-creates if missing).
     * 5. Updates the user record in the `admin_users` table.
     *
     * ## Validation Rules
     *
     * - **first_name**, **last_name**: required
     * - **designation_id**, **user_type**: required
     *
     * ## File Upload (Optional)
     *
     * - Expects a file input named `pro_image`.
     * - Stores in `/uploads/{code}/`.
     * - Renames file safely to avoid conflicts.
     * - Updates `image` field in DB if new file is uploaded.
     *
     * ## Response Format
     *
     * On success:
     * ```json
     * {
     *   "status": "success",
     *   "message": "User updated successfully."
     * }
     * ```
     *
     * On failure (validation, upload, or DB error):
     * ```json
     * {
     *   "status": "error",
     *   "message": "User update failed."
     * }
     * ```
     *
     * ## Notes
     *
     * - User identity fields (`user_id`, `email`, `code`) are NOT updatable.
     * - Password is not changed here (only profile info is updated).
     * - Uses `AdminUserModel::update()` for saving.
     * - Designed for AJAX form submission with JSON responses.
     *
     * @since   1.0.0
     * @access  public
     *
     * @param   int $id  User ID of the admin member to update.
     * @return  \CodeIgniter\HTTP\Response
     *          JSON response with operation status and message.
     */
    public function update_admin_member($id)
    {
        $adminUserModel = new AdminUserModel();

        // First get the existing user
        $user = $adminUserModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'User not found.'
            ]);
        }

        $rules = [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'designation_id'    => 'required',
            'user_type'    => 'required',
        ];

        $rules = str_replace('{id}', $id, $rules); // replace placeholder for is_unique

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }        

        // Collect posted values (user_id/email is NOT updateable)
        $update_data = [
            'first_name'          => $this->request->getPost('first_name') ?: null,
            'last_name'           => $this->request->getPost('last_name') ?: null,
            'mobile'              => $this->request->getPost('mobile') ?: null,
            'gender'              => $this->request->getPost('gender') ?: null,
            'dept_id'             => (int) $this->request->getPost('user_type') ?: null,
            'designation_id'      => (int) $this->request->getPost('designation_id') ?: null,
            'address'             => $this->request->getPost('address') ?: null,
            'city'                => $this->request->getPost('city') ?: null,
            'state'               => $this->request->getPost('state') ?: null,
            'pincode'             => $this->request->getPost('pincode') ?: null,
            'country'             => $this->request->getPost('country') ?: null,
            'qualification'       => $this->request->getPost('qualification') ?: null,
            'extra_qualification' => $this->request->getPost('extra_qualification') ?: null,
            'experience'          => $this->request->getPost('experience') ?: null,
            'date_of_birth'       => $this->request->getPost('date_of_birth') ?: null,
            'present_address'     => $this->request->getPost('present_address') ?: null,
            'pancard_number'      => strtoupper($this->request->getPost('pancard_number') ?: null),
            'aadhar_number'       => strtoupper($this->request->getPost('aadhar_number') ?: null),
            'phone_no_other'      => $this->request->getPost('phone_no_other') ?: null,
            'bank_name'           => $this->request->getPost('bank_name') ?: null,
            'bank_acc_number'     => $this->request->getPost('bank_acc_number') ?: null,
            'bank_ifsc_number'    => strtoupper($this->request->getPost('bank_ifsc_number') ?: null),
            'esic_number'         => $this->request->getPost('esic_number') ?: null,
            'pf_number'           => strtoupper($this->request->getPost('pf_number') ?: null),
            'oasis_id'            => $this->request->getPost('oasis_id') ?: null,
            'spouse_name'         => $this->request->getPost('spouse_name') ?: null,
            // 'emaill'              => $this->request->getPost('emaill'),
            'useremaill'          => $this->request->getPost('user_email') ?: null,
            'joining_date'        => $this->request->getPost('joining_date') ?: null,
            'subject_tought'      => $this->request->getPost('subject_tought') ?: null,
            'class_taken'         => $this->request->getPost('class_taken') ?: null,
            'status'              => $this->request->getPost('status') ?: null,
        ];

        // echo "<pre>"; print_r($update_data); die();

        // Handle image upload
        $file = $this->request->getFile('pro_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $studentCode = $update_data['code'];
            $basePath = FCPATH . 'uploads';
            $targetPath = $basePath . DIRECTORY_SEPARATOR . $studentCode;

            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $originalName = $file->getClientName();
            $safeName = preg_replace('~[^A-Za-z0-9_.\-]~', '_', $originalName);

            if (file_exists($targetPath . DIRECTORY_SEPARATOR . $safeName)) {
                $nameNoExt = pathinfo($safeName, PATHINFO_FILENAME);
                $ext = $file->getExtension();
                $safeName = $nameNoExt . '_' . date('Ymd_His') . '.' . $ext;
            }

            try {
                $file->move($targetPath, $safeName, true);
                $update_data['image'] = $safeName;
            } catch (\Throwable $e) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]);
            }
        }

        // Save to DB
        if ($adminUserModel->update($id, $update_data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'User updated successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'User update failed.'
        ]);
    }

    /**
     * Toggle or update the current status of an admin member.
     *
     * Handles AJAX requests to change the `status` field of a specific
     * admin user. Typically used for enabling/disabling or activating/
     * deactivating a member from the admin panel.
     *
     * ## Process
     * 1. Reads the user ID (`id`) and new status value (`is_checked`)
     *    from POST data.
     * 2. Updates the `status` field in the `admin_users` table using
     *    `AdminUserModel`.
     * 3. Returns a JSON response indicating whether the update was
     *    successful or failed.
     *
     * ## Request Parameters
     * - **id**: (int) Required. The ID of the admin member.
     * - **is_checked**: (string|int|bool) Required. The new status value
     *   (e.g., `1` for active, `0` for inactive).
     *
     * ## Response Format
     *
     * On success:
     * ```json
     * {
     *   "status": "success"
     * }
     * ```
     *
     * On failure:
     * ```json
     * {
     *   "status": "false"
     * }
     * ```
     *
     * ## Notes
     * - Does not perform deep validation; assumes `id` and `is_checked`
     *   are provided correctly.
     * - Intended to be used with toggle switches or status update buttons
     *   in the UI.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  \CodeIgniter\HTTP\Response
     *          JSON response with the update status.
     */
    public function setCurrentStatus()
    {
        $id = $this->request->getPost('id');
        $is_checked = $this->request->getPost('is_checked');

        $adminUserModel = new AdminUserModel();
        $response = $adminUserModel->update($id, ['status' => $is_checked]);

        if($response) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'false']);
        }
    }

    /**
     * Delete an admin member by ID.
     *
     * This method handles an AJAX request to delete an admin user.
     * It performs several checks before deletion:
     *  - Ensures the provided ID is valid and numeric.
     *  - Confirms that the user exists in the database.
     *  - Prevents the currently logged-in admin from deleting their own account.
     *
     * On success or failure, a JSON response is returned with:
     *  - status: "success" or "error"
     *  - message: description of the result
     *
     * @param int|null $id  The ID of the admin user to be deleted.
     * @return \CodeIgniter\HTTP\Response JSON response indicating success or failure.
     */
    public function delete_admin_member($id = null) {
        $adminUserModel = new AdminUserModel();

        // ✅ Check: valid ID provided
        if (!$id || !is_numeric($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid user ID.']);
        }

        // ✅ Check: does the user exist?
        $user = $adminUserModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found.']);
        }

        // ✅ Optional Check: prevent deleting yourself
        $currentUserId = $this->session->get('user_id');
        if ($currentUserId == $id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'You cannot delete your own account.']);
        }

        // ✅ Attempt delete
        if ($adminUserModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete user.']);
        }
    }

    /**
     * Display the staff card generation page.
     *
     * Prepares and renders the view for generating staff cards. This method:
     *
     * 1. Sets the page title (`Generate Staff Card`).
     * 2. Loads and renders the common layout views (header, topbar, sidebar, footer).
     * 3. Fetches all session years from the `SessionYearModel` in descending order
     *    (latest first).
     * 4. Passes the session year list and page title into the staff card
     *    management view.
     *
     * ## View Rendered
     * - `admin/staff-management/generate-staff-card/list`
     *
     * ## Notes
     * - This method only prepares data and loads views; it does not perform
     *   any staff card generation itself.
     * - Intended as the entry point for the staff card generation UI.
     *
     * @since   1.0.0
     * @access  public
     *
     * @return  void
     *          Renders staff card generation page with session year data.
     */
    public function generate_staff_card()
    {
        $data['title'] = "Generate Staff Card";

        echo view('admin/common/header', $data);
        echo view('admin/common/topbar', $data);
        echo view('admin/common/sidebar', $data);
        
        $sessionYearModel = new SessionYearModel();
        $data['session_year'] = $sessionYearModel->orderBy('id', 'DESC')->findAll();
        echo view('admin/staff-management/generate-staff-card/list', $data);  

        echo view('admin/common/footer', $data);
    }
}    