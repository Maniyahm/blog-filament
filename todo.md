11/11/2024

0. General
    <!-- - Show panel name in side bar like "Blog Filament - User|Author|Admin" -->
    <!-- - Create static page for AboutUs,Privacy,Terms -->
    - Blogs shoud have 
        <!-- - Tags (multiple) (shoulkd store in tags table) (store tags ids in tags column + add option to create new tag on blog create/edit) -->
        <!-- - Categories (should come from categories table) (simple dropdown single select) -->
        - Author dropdown (in admin blog edit)
    - Add moderations for author and user (LP)
        - on register author and user will have pending status, admin will manually approve mark them, once approved they will be able to access the platform
        - Send notifications
    - On new blog by author, the blog will requires admin approval, send notifications (LP)


1. Users
    - Blog Resource (List + View Only) with filter but card view
        <!-- - On blog view show share action, download action, reaction action, action to export blog to pdf -->
        - Show comment in relation on blog view + user can create comment
        <!-- - List should be searchable, filterable by category -->
    - Contact Us
        - Custom Page with form => show name, email, reason, subject fields, onsubmit make entry to contact us table
    <!-- - In sidebar add links for privacy, terms, about -->
    - Try to remove the default dashboard screen and on login/register redirect to /blogs list
    - Chek if we can move sidebar to top

2. Admins
    - Resources
        - Blogs
            - Bulk Action to publish many posts
        - Blog Categories
        - Authors
            - Bulk Action to approve authors
        - Users
        - Contact Form Entris (full resource with list n view)
        - Stats on dashboard + latest blogs list + view count chart


3. Authors
    - Blog Resource
    - In sidebar add links for privacy, terms, about
    - Stats on dashboard + latest blogs list + latest comments list + view count chart
    - Reports 
        - Blog daily view count report
            - create a table called blog_impressions
            - on user viewing blog, make entry in this table
            - In mysql create a view to show daily count of view for each blog
            - then create a model and create view only filament resource
    - On blog list 
        - give custom action to down last 30 days report in csv file