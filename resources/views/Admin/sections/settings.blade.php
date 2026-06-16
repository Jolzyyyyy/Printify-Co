   <!-- FINAL ADMIN SETTINGS UI - Alpine.js Admin Portal Section -->
<!-- Required once in your layout: <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<div x-data="adminSettingsFinal()" x-init="init()" class="settings-admin-shell">
    <div x-show="toast.show" x-transition class="admin-feedback-toast" x-text="toast.message" style="display:none"></div>

    <!-- Dashboard-style Calendar / Date Modal -->
    <div class="settings-calendar-overlay" x-show="calendar.open" x-transition.opacity @click.self="closeCalendar()" @keydown.escape.window="closeCalendar()" style="display:none">
        <div class="settings-calendar-modal" @click.stop>
            <div class="settings-calendar-main">
                <div class="settings-calendar-headline">
                    <div class="settings-calendar-intro">
                        <h3>Settings Calendar</h3>
                        <p>Select a date, add notes, and use the range in the Settings header.</p>
                    </div>
                    <div class="settings-calendar-nav-main">
                        <button type="button" class="settings-calendar-icon-btn" @click="prevMonth()" title="Previous month"><i data-lucide="chevron-left"></i></button>
                        <button type="button" class="settings-calendar-action-btn settings-calendar-today-btn" @click="goToday()"><i data-lucide="calendar-check"></i> Today</button>
                        <button type="button" class="settings-calendar-icon-btn" @click="nextMonth()" title="Next month"><i data-lucide="chevron-right"></i></button>
                    </div>
                    <button type="button" class="settings-calendar-icon-btn settings-calendar-close-btn" @click="closeCalendar()" title="Close calendar"><i data-lucide="x"></i></button>
                </div>

                <div class="settings-calendar-monthbar">
                    <h3 class="settings-calendar-title" x-text="calendar.monthTitle"></h3>
                    <button type="button" class="settings-calendar-action-btn settings-calendar-use-top" @click="applySelectedDate()"><i data-lucide="check"></i> Use Date</button>
                </div>

                <div class="settings-calendar-weekdays">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div class="settings-calendar-grid">
                    <template x-for="day in calendar.days" :key="day.key">
                        <button type="button" class="settings-calendar-day" :class="{'is-muted': !day.current, 'is-today': day.isToday, 'is-selected': day.date === calendar.selectedDate}" @click="selectCalendarDate(day)">
                            <span class="settings-calendar-day-number" x-text="day.number"></span>
                            <span class="settings-calendar-day-events">
                                <template x-for="event in eventsForDate(day.date).slice(0,3)" :key="event.id">
                                    <i class="settings-calendar-event-dot"></i>
                                </template>
                                <span class="settings-calendar-more" x-show="eventsForDate(day.date).length > 3" x-text="'+' + (eventsForDate(day.date).length - 3)"></span>
                            </span>
                        </button>
                    </template>
                </div>
            </div>

            <aside class="settings-calendar-side">
                <h3 class="settings-calendar-selected-date" x-text="selectedDateLong()"></h3>
                <div class="settings-calendar-event-list" x-show="eventsForDate(calendar.selectedDate).length">
                    <template x-for="event in eventsForDate(calendar.selectedDate)" :key="event.id">
                        <div class="settings-calendar-event-item">
                            <div class="settings-calendar-event-title" x-text="event.title"></div>
                            <div class="settings-calendar-event-meta" x-text="event.time"></div>
                            <div class="settings-calendar-event-note" x-text="event.note"></div>
                            <div class="settings-calendar-event-actions">
                                <button type="button" class="settings-calendar-mini-btn" @click="editEvent(event)">Edit</button>
                                <button type="button" class="settings-calendar-mini-btn danger" @click="removeEvent(event.id)">Delete</button>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="settings-calendar-empty" x-show="!eventsForDate(calendar.selectedDate).length">No schedule yet for this date.</div>

                <div class="settings-calendar-form">
                    <label class="settings-calendar-field"><span>Title</span><input x-model="calendar.form.title" type="text" placeholder="Add settings task"></label>
                    <label class="settings-calendar-field"><span>Time</span><input x-model="calendar.form.time" type="time"></label>
                    <label class="settings-calendar-field"><span>Notes</span><textarea x-model="calendar.form.note" placeholder="Short reminder or admin note"></textarea></label>
                    <div class="settings-calendar-form-actions">
                        <button type="button" class="settings-calendar-clear-btn" @click="clearEventForm()">Clear</button>
                        <button type="button" class="settings-calendar-save-btn" @click="saveCalendarEvent()"><i data-lucide="save"></i> Save</button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <section class="admin-page-head admin-title-line">
        <div>
            <h1>Admin Settings</h1>
            <p>Manage account, business, system, billing, and team preferences.</p>
        </div>
        <div class="admin-head-actions">
            <button class="admin-date-control" @click="openCalendar()">
                <i data-lucide="calendar-days"></i>
                <span x-text="calendar.label"></span>
                <i data-lucide="chevron-down"></i>
            </button>
            <button class="admin-btn admin-btn-outline" @click="exportSettings()">
                <i data-lucide="download"></i>
                <span>Export</span>
            </button>
            <button class="admin-btn admin-btn-primary" @click="saveAll()">
                <i data-lucide="save"></i>
                <span>Save Changes</span>
            </button>
        </div>
    </section>

    <section class="settings-top-grid">
        <article class="admin-main-box settings-card photo-card">
            <div class="card-title-row"><i data-lucide="user-round"></i><h2>Profile Photo</h2></div>
            <div class="photo-preview-wrap">
                <img :src="profile.photo" alt="Profile photo" class="profile-photo-preview">
                <button class="photo-edit-btn" @click="$refs.photoInput.click()"><i data-lucide="pencil"></i></button>
            </div>
            <input x-ref="photoInput" type="file" accept="image/png,image/jpeg,image/gif" hidden @change="changePhoto($event)">
            <button class="admin-btn admin-btn-outline full-width" @click="$refs.photoInput.click()"><i data-lucide="upload"></i><span>Change Photo</span></button>
            <p class="small-help">JPG, PNG or GIF. Max size 2MB.</p>
        </article>

        <article class="admin-main-box settings-card profile-card">
            <div class="card-title-row"><i data-lucide="user-round"></i><h2>Profile Info</h2></div>
            <div class="settings-form-grid">
                <label class="form-control"><span>Full Name</span><input x-model="profile.fullName" type="text"></label>
                <label class="form-control"><span>Timezone</span><select x-model="profile.timezone"><option>(UTC+08:00) Manila, Philippines</option><option>(UTC-08:00) Pacific Time (US & Canada)</option><option>(UTC+00:00) London, United Kingdom</option></select></label>
                <label class="form-control"><span>Email Address</span><input x-model="profile.email" type="email"></label>
                <label class="form-control"><span>Language</span><select x-model="profile.language"><option>English (US)</option><option>Tagalog</option></select></label>
                <label class="form-control"><span>Phone Number</span><input x-model="profile.phone" type="text"></label>
                <label class="form-control tall"><span>Business Address</span><textarea x-model="profile.address"></textarea></label>
                <label class="form-control"><span>Role</span><select x-model="profile.role"><option>Admin Client</option><option>Developer</option><option>Customer</option></select></label>
                <label class="form-control"><span>Company / Business Name</span><input x-model="business.name" type="text"></label>
            </div>
            <button class="admin-btn admin-btn-primary card-save-btn" @click="saveProfile()"><i data-lucide="lock-keyhole"></i><span>Save Changes</span></button>
        </article>

        <article class="admin-main-box settings-card business-card">
            <div class="card-title-row"><i data-lucide="briefcase-business"></i><h2>Business Information</h2></div>
            <div class="settings-form-grid">
                <label class="form-control"><span>Business Name</span><input x-model="business.name" type="text"></label>
                <label class="form-control"><span>Business Type</span><input x-model="business.type" type="text"></label>
                <label class="form-control"><span>Support Email</span><input x-model="business.supportEmail" type="email"></label>
                <label class="form-control tall"><span>Billing Address</span><textarea x-model="business.billingAddress"></textarea></label>
                <label class="form-control"><span>Website</span><input x-model="business.website" type="url"></label>
                <label class="form-control"><span>Default Currency</span><select x-model="business.currency"><option>PHP - Philippine Peso (₱)</option><option>USD - US Dollar ($)</option></select></label>
                <label class="form-control"><span>Tax / VAT ID</span><input x-model="business.taxId" type="text"></label>
                <label class="form-control"><span>Region</span><select x-model="business.region"><option>Philippines</option><option>United States</option></select></label>
            </div>
        </article>
    </section>

    <section class="settings-mid-grid">
        <article class="admin-main-box settings-card compact-card">
            <div class="card-title-row"><i data-lucide="shield-check"></i><h2>Security</h2></div>
            <div class="settings-list">
                <div class="settings-line"><span>Password</span><b>••••••••••</b><button class="mini-btn" @click="changePassword()">Change</button></div>
                <div class="settings-line"><span>Active Sessions</span><b x-text="security.sessions + ' active sessions'"></b><button class="mini-btn" @click="viewSessions()">View</button></div>
                <div class="settings-line"><span>Recovery Methods</span><b x-text="security.recovery + ' methods set'"></b><button class="mini-btn" @click="showToast('Recovery methods opened')">Manage</button></div>
                <div class="settings-line"><span>Login Alerts</span><strong class="green-text">Enabled</strong><button class="mini-btn" @click="showToast('Login alerts updated')">Manage</button></div>
            </div>
        </article>

        <article class="admin-main-box settings-card compact-card">
            <div class="card-title-row"><i data-lucide="bell"></i><h2>Notifications</h2></div>
            <div class="settings-list toggle-list">
                <template x-for="item in notifications" :key="item.key">
                    <button class="settings-line toggle-row" @click="item.on = !item.on; showToast(item.label + (item.on ? ' enabled' : ' disabled'))">
                        <span><i :data-lucide="item.icon"></i><b x-text="item.label"></b></span>
                        <i class="settings-toggle" :class="!item.on && 'off'"></i>
                    </button>
                </template>
            </div>
        </article>

        <article class="admin-main-box settings-card compact-card">
            <div class="card-title-row"><i data-lucide="credit-card"></i><h2>Billing & Subscription</h2></div>
            <div class="billing-grid">
                <div><small>Current Plan</small><b><span class="plan-pill">Pro</span> For growing businesses</b></div>
                <div><small>Billing Cycle</small><b>Monthly</b></div>
                <div><small>Next Renewal</small><b>Jun 14, 2026</b></div>
                <div><small>Payment Method</small><b>VISA •••• 4242 <span class="primary-pill">Primary</span></b></div>
            </div>
            <div class="button-pair">
                <button class="admin-btn admin-btn-outline" @click="viewInvoices()"><i data-lucide="file-text"></i><span>View Invoices</span></button>
                <button class="admin-btn admin-btn-primary" @click="showToast('Subscription manager opened')"><i data-lucide="settings"></i><span>Manage Subscription</span></button>
            </div>
        </article>
    </section>

    <section class="admin-main-box auth-policy-section">
        <div class="team-head">
            <div class="card-title-row">
                <i data-lucide="shield-check"></i>
                <div>
                    <h2>Authentication Policy</h2>
                    <p>Current login, OTP, cooldown, and password reset rules for customer, admin client, and developer access.</p>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="team-table auth-policy-table">
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Attempts Allowed</th>
                        <th>Cooling / Lockout Period</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Developer login</td><td>5 failed attempts</td><td>5 minutes</td><td>Uses the protected staff portal and persists after reload.</td></tr>
                    <tr><td>Admin-client login</td><td>5 failed attempts</td><td>5 minutes</td><td>Uses the protected staff portal; account must be developer-approved.</td></tr>
                    <tr><td>Legacy admin role</td><td>N/A</td><td>N/A</td><td>Legacy admin accounts are migrated to admin-client; there is no separate admin role in the current setup.</td></tr>
                    <tr><td>Customer login</td><td>3 failed attempts</td><td>5 minutes</td><td>Uses a separate customer email/password throttle.</td></tr>
                    <tr><td>Staff OTP verification</td><td>5 wrong OTP attempts</td><td>15 minutes</td><td>Applies to developer, approved admin-client, and staff password reset OTP flows.</td></tr>
                    <tr><td>Customer OTP verification</td><td>3 wrong OTP attempts</td><td>15 minutes</td><td>Applies to customer login, registration, social login, and customer password reset OTP flows.</td></tr>
                    <tr><td>Staff OTP resend</td><td>1 resend</td><td>60 seconds</td><td>Countdown persists after reload.</td></tr>
                    <tr><td>Customer OTP resend</td><td>1 resend</td><td>60 seconds</td><td>Countdown persists after reload.</td></tr>
                    <tr><td>OTP code validity</td><td>N/A</td><td>Expires after 5 minutes</td><td>User must request a new OTP after expiry.</td></tr>
                    <tr><td>Customer password reset request</td><td>1 request</td><td>60 seconds</td><td>Redirects to the existing OTP verification screen while a reset OTP is pending.</td></tr>
                    <tr><td>Staff password reset request</td><td>1 request</td><td>60 seconds</td><td>Available only for developer and approved admin-client accounts; redirects to pending OTP when applicable.</td></tr>
                    <tr><td>Wrong-role sign-in</td><td>Counts as failed login attempt</td><td>Uses that portal's login cooldown</td><td>Customer and staff portals reject the wrong role with a clear mismatch message.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="settings-bottom-grid">
        <article class="admin-main-box settings-card integrations-card">
            <div class="card-title-row"><i data-lucide="puzzle"></i><h2>Integrations</h2></div>
            <div class="integration-grid">
                <template x-for="integration in integrations" :key="integration.name">
                    <button class="integration-card clickable-main-box" @click="toggleIntegration(integration)">
                        <span class="integration-logo" :class="integration.color"><i :data-lucide="integration.icon"></i></span>
                        <b x-text="integration.name"></b>
                        <small :class="integration.connected ? 'connected' : 'not-connected'"><i></i><span x-text="integration.connected ? 'Connected' : 'Not Connected'"></span></small>
                        <em x-text="integration.connected ? 'Manage' : 'Connect'"></em>
                    </button>
                </template>
            </div>
        </article>

        <article class="admin-main-box settings-card api-card">
            <div class="card-title-row"><i data-lucide="code-xml"></i><h2>API & System</h2></div>
            <div class="settings-list">
                <div class="settings-line"><span>API Key Management</span><button class="mini-btn wide" @click="generateApiKey()">Manage Keys</button></div>
                <div class="settings-line"><span>Webhook Status</span><strong class="green-text"><i class="status-dot"></i> Active</strong><button class="mini-btn wide" @click="showToast('Webhooks opened')">View Webhooks</button></div>
                <div class="settings-line"><span>Environment</span><b class="env-pill">Production</b></div>
                <div class="settings-line"><span>Access Token</span><strong class="green-text"><i class="status-dot"></i> Active</strong><button class="mini-btn wide" @click="revokeTokens()">Revoke All</button></div>
                <div class="settings-line"><span>System Preferences</span><button class="mini-btn wide" @click="showToast('System preferences opened')">Configure</button></div>
            </div>
        </article>
    </section>

    <section class="admin-main-box team-section">
        <div class="team-head">
            <div class="card-title-row"><i data-lucide="users-round"></i><div><h2>Team & Permissions</h2><p>Manage team members, roles, and access permissions.</p></div></div>
            <button class="admin-btn admin-btn-primary" @click="inviteMember()"><i data-lucide="plus"></i><span>Invite Member</span></button>
        </div>
        <div class="table-responsive">
            <table class="team-table">
                <thead><tr><th>Member</th><th>Email</th><th>Role</th><th>Permissions</th><th>Last Active</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <template x-for="member in team" :key="member.email">
                        <tr>
                            <td><span class="member-cell"><img :src="member.avatar" alt=""><b x-text="member.name"></b></span></td>
                            <td x-text="member.email"></td>
                            <td><span class="role-pill" x-text="member.role"></span></td>
                            <td x-text="member.permissions"></td>
                            <td x-text="member.lastActive"></td>
                            <td><span class="status-pill" :class="member.status === 'Active' ? 'status-active' : 'status-invited'"><i></i><span x-text="member.status"></span></span></td>
                            <td><div class="table-action-row"><button @click="editMember(member)" title="Edit"><i data-lucide="pencil"></i></button><button @click="removeMember(member)" title="More"><i data-lucide="more-vertical"></i></button></div></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
function adminSettingsFinal(){return{
    toast:{show:false,message:''},
    calendar:{open:false,label:'May 14, 2026 - Present',monthCursor:null,monthTitle:'',selectedDate:'',days:[],editingId:null,form:{title:'',time:'09:00',note:''},events:[{id:1,date:new Date().toISOString().slice(0,10),title:'Review settings',time:'09:00',note:'Check profile, security, and system preferences.'}]},
    profile:{fullName:'Admin Client User',email:'adminclient@example.com',phone:'+1 (555) 123-4567',timezone:'(UTC-08:00) Pacific Time (US & Canada)',language:'English (US)',role:'Admin Client',address:'123 Commerce St, Suite 500\nLos Angeles, CA 90013, USA',photo:'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=240&h=240&fit=crop&crop=face'},
    business:{name:'JTC ECOM (Print-On-Demand)',type:'E-commerce',supportEmail:'support@jtcecom.com',billingAddress:'123 Commerce St, Suite 500\nLos Angeles, CA 90013, USA',website:'https://jtcecom.com',currency:'USD - US Dollar ($)',taxId:'US123456789',region:'United States'},
    security:{tfa:true,sessions:3,recovery:2},
    notifications:[
        {key:'orders',label:'Order Alerts',icon:'clipboard-list',on:true},
        {key:'tasks',label:'Task / Status Updates',icon:'circle-dot',on:true},
        {key:'stock',label:'Low Stock Alerts',icon:'triangle-alert',on:true},
        {key:'marketing',label:'Marketing Updates',icon:'megaphone',on:true},
        {key:'system',label:'System Announcements',icon:'shield-check',on:true},
        {key:'weekly',label:'Weekly Reports',icon:'calendar-clock',on:false}
    ],
    integrations:[
        {name:'Printful',icon:'printer',color:'logo-red',connected:true},
        {name:'Printify',icon:'leaf',color:'logo-green',connected:true},
        {name:'Gelato',icon:'gem',color:'logo-black',connected:true},
        {name:'SPOD',icon:'square',color:'logo-black',connected:true},
        {name:'Stripe',icon:'badge-dollar-sign',color:'logo-purple',connected:true},
        {name:'Slack',icon:'message-square',color:'logo-cyan',connected:true},
        {name:'Zapier',icon:'asterisk',color:'logo-orange',connected:false}
    ],
    team:[
        {name:'Admin Client User',email:'adminclient@example.com',role:'Admin Client',permissions:'Scoped Permissions',lastActive:'May 12, 2025 9:41 AM',status:'Active',avatar:'https://i.pravatar.cc/80?img=12'},
        {name:'Jane Manager',email:'jane.manager@example.com',role:'Manager',permissions:'Orders, Products, Reports',lastActive:'May 11, 2025 4:22 PM',status:'Active',avatar:'https://i.pravatar.cc/80?img=47'},
        {name:'Mike Customer',email:'mike.customer@example.com',role:'Support',permissions:'Support, Products',lastActive:'May 9, 2025 11:08 AM',status:'Invited',avatar:'https://i.pravatar.cc/80?img=32'}
    ],
    init(){this.initCalendar();this.refreshIcons();window.addEventListener('printify-admin-feedback',e=>this.showToast(e.detail?.message||'Updated'));},
    initCalendar(){const today=new Date();this.calendar.monthCursor=new Date(today.getFullYear(),today.getMonth(),1);this.calendar.selectedDate=this.formatDateKey(today);this.buildCalendar();this.calendar.label=this.formatShortDate(today)+' - Present';},
    openCalendar(){this.calendar.open=true;this.buildCalendar();this.refreshIcons();document.body.classList.add('settings-calendar-lock');},
    closeCalendar(){this.calendar.open=false;document.body.classList.remove('settings-calendar-lock');this.refreshIcons();},
    formatDateKey(date){const y=date.getFullYear();const m=String(date.getMonth()+1).padStart(2,'0');const d=String(date.getDate()).padStart(2,'0');return `${y}-${m}-${d}`;},
    formatShortDate(date){return date.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});},
    selectedDateLong(){const d=new Date(this.calendar.selectedDate+'T00:00:00');return d.toLocaleDateString('en-US',{weekday:'long',month:'long',day:'numeric',year:'numeric'});},
    buildCalendar(){const cursor=this.calendar.monthCursor||new Date();const y=cursor.getFullYear();const m=cursor.getMonth();this.calendar.monthTitle=cursor.toLocaleDateString('en-US',{month:'long',year:'numeric'});const first=new Date(y,m,1);const start=new Date(first);start.setDate(first.getDate()-first.getDay());const todayKey=this.formatDateKey(new Date());this.calendar.days=Array.from({length:42},(_,i)=>{const d=new Date(start);d.setDate(start.getDate()+i);return{key:this.formatDateKey(d)+'-'+i,date:this.formatDateKey(d),number:d.getDate(),current:d.getMonth()===m,isToday:this.formatDateKey(d)===todayKey};});this.refreshIcons();},
    prevMonth(){this.calendar.monthCursor=new Date(this.calendar.monthCursor.getFullYear(),this.calendar.monthCursor.getMonth()-1,1);this.buildCalendar();},
    nextMonth(){this.calendar.monthCursor=new Date(this.calendar.monthCursor.getFullYear(),this.calendar.monthCursor.getMonth()+1,1);this.buildCalendar();},
    goToday(){const today=new Date();this.calendar.monthCursor=new Date(today.getFullYear(),today.getMonth(),1);this.calendar.selectedDate=this.formatDateKey(today);this.buildCalendar();},
    selectCalendarDate(day){if(!day.current){const d=new Date(day.date+'T00:00:00');this.calendar.monthCursor=new Date(d.getFullYear(),d.getMonth(),1);}this.calendar.selectedDate=day.date;this.buildCalendar();},
    applySelectedDate(){const d=new Date(this.calendar.selectedDate+'T00:00:00');this.calendar.label=this.formatShortDate(d)+' - Present';this.showToast('Settings date range updated');this.closeCalendar();},
    eventsForDate(date){return this.calendar.events.filter(event=>event.date===date);},
    clearEventForm(){this.calendar.editingId=null;this.calendar.form={title:'',time:'09:00',note:''};},
    saveCalendarEvent(){if(!this.calendar.form.title.trim()){this.showToast('Add a title first');return;}if(this.calendar.editingId){const item=this.calendar.events.find(event=>event.id===this.calendar.editingId);if(item){item.title=this.calendar.form.title.trim();item.time=this.calendar.form.time||'09:00';item.note=this.calendar.form.note||'No notes';}}else{this.calendar.events.push({id:Date.now(),date:this.calendar.selectedDate,title:this.calendar.form.title.trim(),time:this.calendar.form.time||'09:00',note:this.calendar.form.note||'No notes'});}this.clearEventForm();this.showToast('Calendar item saved');this.refreshIcons();},
    editEvent(event){this.calendar.editingId=event.id;this.calendar.form={title:event.title,time:event.time,note:event.note};this.refreshIcons();},
    removeEvent(id){this.calendar.events=this.calendar.events.filter(event=>event.id!==id);if(this.calendar.editingId===id)this.clearEventForm();this.showToast('Calendar item removed');},
    refreshIcons(){this.$nextTick(()=>{if(window.lucide) window.lucide.createIcons();});},
    showToast(message){this.toast.message=message;this.toast.show=true;setTimeout(()=>this.toast.show=false,2400);this.refreshIcons();},
    saveAll(){localStorage.setItem('admin-settings-final',JSON.stringify({profile:this.profile,business:this.business,notifications:this.notifications,integrations:this.integrations,team:this.team}));this.showToast('All settings saved successfully');},
    saveProfile(){this.showToast('Profile changes saved');},
    changePhoto(event){const file=event.target.files?.[0];if(!file)return;if(file.size>2*1024*1024){this.showToast('File is too large. Max size is 2MB.');return;}this.profile.photo=URL.createObjectURL(file);this.showToast('Profile photo updated');this.refreshIcons();},
    changePassword(){this.showToast('Password reset link prepared');},
    toggleTfa(){this.security.tfa=!this.security.tfa;this.showToast(this.security.tfa?'Two-factor authentication enabled':'Two-factor authentication disabled');},
    viewSessions(){this.showToast('Active sessions opened');},
    viewInvoices(){const rows=[['Invoice','Date','Amount','Status'],['INV-1001','May 14, 2026','USD 49.00','Paid'],['INV-1002','Jun 14, 2026','USD 49.00','Upcoming']];this.downloadCsv('billing-invoices.csv',rows);this.showToast('Invoices exported');},
    exportSettings(){const rows=[['Section','Field','Value'],['Profile','Full Name',this.profile.fullName],['Profile','Email',this.profile.email],['Business','Business Name',this.business.name],['Business','Region',this.business.region],['Billing','Plan','Pro']];this.downloadCsv('admin-settings-export.csv',rows);this.showToast('Settings exported as CSV');},
    downloadCsv(filename,rows){const csv=rows.map(r=>r.map(v=>'"'+String(v).replaceAll('"','""')+'"').join(',')).join('\n');const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([csv],{type:'text/csv'}));a.download=filename;a.click();URL.revokeObjectURL(a.href);},
    toggleIntegration(integration){integration.connected=!integration.connected;this.showToast(integration.name+(integration.connected?' connected':' disconnected'));this.refreshIcons();},
    generateApiKey(){const key='pk_live_'+Math.random().toString(36).slice(2,14);navigator.clipboard?.writeText(key);this.showToast('New API key generated and copied');},
    revokeTokens(){this.showToast('All access tokens revoked');},
    inviteMember(){const email=prompt('Enter member email:');if(!email)return;this.team.push({name:'New Member',email,role:'Invited',permissions:'Pending setup',lastActive:'Not active yet',status:'Invited',avatar:'https://i.pravatar.cc/80?u='+encodeURIComponent(email)});this.showToast('Invitation sent to '+email);this.refreshIcons();},
    editMember(member){const role=prompt('Update role:',member.role);if(role){member.role=role;this.showToast(member.name+' role updated');}},
    removeMember(member){if(confirm('Remove '+member.name+' from team?')){this.team=this.team.filter(m=>m.email!==member.email);this.showToast(member.name+' removed');}}
}}
</script>

<style id="settings-auth-policy-table">
    .settings-admin-shell .auth-policy-section{
        margin:0 0 16px!important;
        padding:0!important;
        overflow:hidden!important;
        background:#fff!important;
    }
    .settings-admin-shell .auth-policy-table{
        min-width:860px!important;
    }
    .settings-admin-shell .auth-policy-table th{
        color:#0f172a!important;
        font-family:'Poppins',system-ui,sans-serif!important;
        font-size:12px!important;
        font-weight:800!important;
        vertical-align:top!important;
    }
    .settings-admin-shell .auth-policy-table td{
        height:auto!important;
        min-height:52px!important;
        padding-top:14px!important;
        padding-bottom:14px!important;
        vertical-align:top!important;
        line-height:1.55!important;
        color:#1f2937!important;
    }
    .settings-admin-shell .auth-policy-table td:first-child{
        color:#050816!important;
        font-weight:700!important;
        white-space:nowrap!important;
    }
    .settings-admin-shell .auth-policy-table td:nth-child(2),
    .settings-admin-shell .auth-policy-table td:nth-child(3){
        font-weight:600!important;
    }
    .settings-admin-shell .auth-policy-table tbody tr:hover{
        background:#f8fbff!important;
    }
    @media(max-width:820px){
        .settings-admin-shell .auth-policy-table{min-width:760px!important;}
        .settings-admin-shell .auth-policy-table td:first-child{white-space:normal!important;}
    }
</style>

<style>
:root{--admin-blue:#0b63f6;--admin-black:#050816;--admin-orange:#f59e0b;--admin-border:#050816;--admin-muted:#667085;--admin-line:#e8edf5;--admin-bg:#fff;--admin-green:#0f9f63;--admin-red:#ef2f2f;--admin-purple:#7c3aed;--admin-radius:13px;--admin-shadow:0 5px 18px rgba(5,8,22,.06);--hover-blur:rgba(22,24,29,.72)}
.settings-admin-shell{font-family:'Inter',system-ui,sans-serif;color:var(--admin-black);background:#fff;max-width:1580px;margin:0 auto;padding:22px 24px 28px;letter-spacing:-.012em}.settings-admin-shell *{box-sizing:border-box}.settings-admin-shell button{font-family:'Inter',system-ui,sans-serif}.settings-admin-shell h1{font-family:'Playfair Display',serif;font-weight:700;font-size:38px;line-height:1.05;margin:0 0 7px}.settings-admin-shell h2,.settings-admin-shell h3,.card-title{font-family:'Poppins',sans-serif;font-weight:600}.settings-admin-shell p,.settings-admin-shell input,.settings-admin-shell select,.settings-admin-shell textarea,.settings-admin-shell td{font-family:'Inter',sans-serif;font-weight:400}.admin-title-line{position:relative;padding-left:12px}.admin-title-line:before{content:"";position:absolute;left:0;top:2px;width:4px;height:46px;background:var(--admin-blue);border-radius:10px}.admin-page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px}.admin-page-head p{font-size:14px;color:#344054;margin:0}.admin-head-actions{display:flex;gap:14px;align-items:center}.admin-btn,.admin-date-control{height:48px;min-width:116px;padding:0 18px;border:0!important;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;gap:10px;font-size:14px;font-weight:700;cursor:pointer;transition:.18s ease;white-space:nowrap;box-shadow:none!important}.admin-btn svg,.admin-date-control svg{width:18px;height:18px;stroke-width:2.1}.admin-btn-primary{background:var(--admin-blue)!important;color:#050816!important}.admin-btn-outline,.admin-date-control{background:#fff!important;color:#050816!important}.admin-btn:hover,.admin-date-control:hover,.mini-btn:hover,.table-action-row button:hover,.photo-edit-btn:hover{background:#050816!important;color:#fff!important;transform:translateY(-1px)}.admin-date-control{min-width:250px}.admin-feedback-toast{position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:6000;background:#050816;color:#fff;border-radius:999px;padding:13px 24px;font-size:14px;font-weight:700;box-shadow:0 16px 50px rgba(5,8,22,.22);text-align:center}.admin-main-box{background:#fff;border:1.8px solid var(--admin-border);border-radius:var(--admin-radius);box-shadow:var(--admin-shadow)}.admin-main-box:hover,.clickable-main-box:hover{background:rgba(33,37,41,.08)}.settings-card{padding:20px}.card-title-row{display:flex;align-items:center;gap:10px;margin-bottom:16px}.card-title-row>svg{width:22px;height:22px;color:var(--admin-blue);stroke-width:2.2}.card-title-row h2{font-size:17px;line-height:1.2;margin:0;color:#09111f}.card-title-row p{font-size:12px;color:#667085;margin:4px 0 0}.settings-top-grid{display:grid;grid-template-columns:1.5fr 250px 1fr;gap:16px;margin-bottom:16px}.settings-mid-grid{display:grid;grid-template-columns:1fr 1fr 1.08fr;gap:16px;margin-bottom:16px}.settings-bottom-grid{display:grid;grid-template-columns:minmax(0,2fr) minmax(340px,.98fr);gap:16px;margin-bottom:16px}.settings-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px 16px}.form-control{display:flex;flex-direction:column;gap:6px}.form-control span{font-family:'Poppins',sans-serif;font-size:11px;font-weight:600;color:#111827}.form-control input,.form-control select,.form-control textarea{width:100%;min-height:38px;border:1px solid #e4e7ec;border-radius:7px;background:#fff;color:#111827;padding:8px 10px;font-size:12px;outline:none}.form-control textarea{height:76px;resize:vertical;line-height:1.35}.form-control input:focus,.form-control select:focus,.form-control textarea:focus{box-shadow:0 0 0 3px rgba(11,99,246,.12);border-color:#0b63f6}.card-save-btn{width:calc(50% - 8px);margin:15px 0 0 auto;display:flex}.photo-card{text-align:center}.photo-preview-wrap{width:150px;height:150px;margin:6px auto 18px;position:relative}.profile-photo-preview{width:150px;height:150px;border-radius:50%;object-fit:cover;background:#f2f4f7}.photo-edit-btn{position:absolute;right:4px;bottom:14px;width:38px;height:38px;border:0;border-radius:50%;background:#fff;color:var(--admin-blue);display:grid;place-items:center;box-shadow:0 6px 18px rgba(5,8,22,.12);cursor:pointer}.photo-edit-btn svg{width:18px}.full-width{width:100%}.small-help{font-size:11px;color:#667085;margin:11px 0 0}.settings-list{display:flex;flex-direction:column}.settings-line{min-height:43px;border-bottom:1px solid #edf1f6;display:grid;grid-template-columns:minmax(0,1fr) auto auto;gap:12px;align-items:center;font-size:13px;color:#111827}.settings-line:last-child{border-bottom:0}.settings-line span{font-weight:500}.settings-line b{font-weight:600}.green-text{font-family:'Poppins',sans-serif;font-size:12px;font-weight:600;color:var(--admin-green);display:inline-flex;align-items:center;gap:6px}.mini-btn{height:34px;min-width:76px;border:0;border-radius:7px;background:#f8fafc;color:var(--admin-blue);font-size:12px;font-weight:700;cursor:pointer}.mini-btn.wide{min-width:112px}.toggle-row{grid-template-columns:1fr auto;border:0;border-bottom:1px solid #edf1f6;background:transparent;text-align:left;cursor:pointer}.toggle-row span{display:flex;align-items:center;gap:10px}.toggle-row span svg{width:16px;height:16px;color:#475467}.settings-toggle{width:42px;height:22px;border-radius:999px;background:#10b981;position:relative;display:inline-block}.settings-toggle:after{content:"";position:absolute;top:3px;right:3px;width:16px;height:16px;border-radius:50%;background:#fff}.settings-toggle.off{background:#cbd5e1}.settings-toggle.off:after{right:auto;left:3px}.billing-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 22px;margin-bottom:18px}.billing-grid>div{min-height:52px;border-bottom:1px solid #edf1f6;padding:4px 0 12px}.billing-grid small{display:block;font-size:11px;color:#667085;margin-bottom:5px}.billing-grid b{font-size:13px;font-weight:600}.plan-pill,.primary-pill,.role-pill,.env-pill{border-radius:6px;background:#eaf1ff;color:#0b63f6;font-family:'Poppins',sans-serif;font-weight:600;font-size:11px;padding:3px 7px}.primary-pill{background:#e7f7ed;color:#0f9f63}.env-pill{background:#e7f7ed;color:#0f9f63}.button-pair{display:grid;grid-template-columns:1fr 1fr;gap:12px}.integration-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:12px}.integration-card{min-height:114px;border:1px solid #e1e6ef;border-radius:10px;background:#fff;padding:13px 10px;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;cursor:pointer;position:relative;overflow:hidden}.integration-logo{height:30px;display:grid;place-items:center}.integration-logo svg{width:26px;height:26px}.logo-red{color:#ef4444}.logo-green{color:#10b981}.logo-black{color:#050816}.logo-purple{color:#635bff}.logo-cyan{color:#0ea5e9}.logo-orange{color:#f97316}.integration-card b{font-size:13px;font-family:'Poppins',sans-serif}.integration-card small{font-style:normal;font-size:11px;font-weight:700;display:flex;align-items:center;gap:6px}.integration-card small i,.status-dot,.status-pill i{width:8px;height:8px;border-radius:50%;display:inline-block;background:currentColor}.connected{color:#0f9f63}.not-connected{color:#ef2f2f}.integration-card em{height:30px;min-width:96px;border-radius:7px;background:#f8fafc;color:#0b63f6;display:inline-flex;align-items:center;justify-content:center;font-style:normal;font-size:12px;font-weight:700}.team-section{padding:0;overflow:hidden}.team-head{padding:18px 22px 10px;display:flex;align-items:flex-start;justify-content:space-between;gap:16px}.team-head .card-title-row{margin-bottom:0}.table-responsive{width:100%;overflow:auto}.team-table{width:100%;border-collapse:collapse;min-width:900px}.team-table th{height:42px;background:#f8fafc;color:#667085;text-align:left;font-size:12px;font-weight:600;padding:0 28px;border-top:1px solid #edf1f6;border-bottom:1px solid #edf1f6}.team-table td{height:58px;padding:0 28px;border-bottom:1px solid #edf1f6;font-size:13px;color:#344054}.team-table tr:last-child td{border-bottom:0}.member-cell{display:flex;align-items:center;gap:12px;color:#111827}.member-cell img{width:32px;height:32px;border-radius:50%;object-fit:cover}.member-cell b{font-size:14px;font-weight:600}.status-pill{height:26px;border-radius:6px;display:inline-flex;align-items:center;gap:7px;padding:0 10px;font-size:12px;font-weight:700}.status-active{background:#e7f7ed;color:#0f9f63}.status-invited{background:#fff3db;color:#f59e0b}.table-action-row{display:flex;gap:9px}.table-action-row button{width:34px;height:34px;border:0;border-radius:7px;background:#f8fafc;color:#050816;display:grid;place-items:center;cursor:pointer}.table-action-row svg{width:17px}.clickable-main-box:after{content:"";position:absolute;inset:0;background:var(--hover-blur);opacity:0;backdrop-filter:blur(2px);transition:.16s}.clickable-main-box:hover:after{opacity:.10}@media(max-width:1300px){.settings-top-grid,.settings-mid-grid,.settings-bottom-grid{grid-template-columns:1fr}.card-save-btn{width:100%}.integration-grid{grid-template-columns:repeat(4,1fr)}}@media(max-width:820px){.settings-admin-shell{padding:16px}.admin-page-head{flex-direction:column}.admin-head-actions{width:100%;flex-wrap:wrap}.admin-date-control{min-width:100%;width:100%}.admin-btn{flex:1}.settings-form-grid,.billing-grid,.button-pair{grid-template-columns:1fr}.integration-grid{grid-template-columns:repeat(2,1fr)}.team-head{flex-direction:column}.team-head .admin-btn{width:100%}.settings-admin-shell h1{font-size:32px}}

/* ===== FINAL SETTINGS REVISION: compact unified top box + no boxes for sections 4-8 ===== */
:root{
  --admin-blue:#0b63f6;
  --admin-blue-dark:#084ac2;
  --admin-black:#050816;
  --admin-border-soft:#d8dee8;
  --admin-panel:#ffffff;
  --admin-soft:#f8fafc;
}
.settings-admin-shell{
  max-width:1440px;
  padding:22px 24px 26px;
  letter-spacing:.01em;
}
.admin-page-head{
  align-items:flex-start;
  margin-bottom:16px;
}
.admin-head-actions{
  display:grid!important;
  grid-template-columns:auto auto;
  gap:10px 12px!important;
  justify-content:end;
  justify-items:end;
  align-items:center;
  min-width:330px;
}
.admin-date-control{
  grid-column:1 / 3;
  justify-self:end;
  min-width:245px!important;
  height:40px!important;
  background:transparent!important;
  box-shadow:none!important;
  padding:0!important;
  color:var(--admin-black)!important;
}
.admin-date-control svg:first-child{color:var(--admin-blue)!important;fill:none!important}.admin-date-control svg{color:var(--admin-black)}
.admin-btn{
  height:40px!important;
  min-height:40px!important;
  min-width:136px!important;
  padding:0 18px!important;
  border-radius:8px!important;
  border:0!important;
  box-shadow:none!important;
  font-size:13px!important;
  font-weight:700!important;
}
.admin-btn-primary{
  background:linear-gradient(135deg,#0b63f6 0%,#095be2 52%,#084ac2 100%)!important;
  color:#050816!important;
}
.admin-btn-outline,.mini-btn,.integration-card em{
  background:#f8fafc!important;
  color:#050816!important;
  border:0!important;
}
.admin-btn svg,.mini-btn svg,.integration-card svg{stroke-width:2.2}.admin-btn-primary svg{color:#050816}.admin-btn-outline svg,.mini-btn svg{color:var(--admin-blue)}
.admin-btn:hover,.admin-date-control:hover,.mini-btn:hover,.integration-card:hover em,.table-action-row button:hover,.photo-edit-btn:hover{
  background:#050816!important;
  color:#fff!important;
  transform:translateY(-1px);
}
.admin-btn:hover svg,.admin-date-control:hover svg,.mini-btn:hover svg,.photo-edit-btn:hover svg{color:#fff!important;stroke:#fff!important}
.admin-title-line:before{background:#0b63f6!important;height:42px;top:0}.settings-admin-shell h1{font-size:36px}.admin-page-head p{font-size:13px}

/* Top area is now ONE box only */
.settings-top-grid{
  display:grid;
  grid-template-columns:minmax(0,1.42fr) 210px minmax(0,1fr)!important;
  gap:12px!important;
  margin-bottom:14px!important;
  background:#fff;
  border:1.4px solid var(--admin-border-soft);
  border-radius:13px;
  box-shadow:0 5px 18px rgba(5,8,22,.04);
  padding:14px 16px!important;
}
.settings-top-grid>.admin-main-box{
  border:0!important;
  box-shadow:none!important;
  border-radius:0!important;
  background:transparent!important;
  padding:0!important;
}
.settings-top-grid>.admin-main-box:hover{background:transparent!important}
.settings-top-grid .photo-card{
  border-left:1px solid #edf1f6!important;
  border-right:1px solid #edf1f6!important;
  padding:0 14px!important;
}
.settings-top-grid .card-title-row{margin-bottom:10px!important}.settings-top-grid .card-title-row h2{font-size:16px!important}.card-title-row>svg{color:#0b63f6!important}
.settings-form-grid{gap:9px 12px!important}.form-control{gap:5px!important}.form-control span{font-size:10.5px!important}.form-control input,.form-control select,.form-control textarea{min-height:34px!important;padding:7px 9px!important;font-size:11.5px!important;border-color:#e1e6ef!important}.form-control textarea{height:54px!important;min-height:54px!important}.card-save-btn{height:38px!important;margin-top:11px!important;width:calc(50% - 6px)!important}.photo-preview-wrap{width:116px!important;height:116px!important;margin:4px auto 12px!important}.profile-photo-preview{width:116px!important;height:116px!important}.photo-edit-btn{width:32px!important;height:32px!important;right:2px!important;bottom:7px!important}.small-help{font-size:10.5px!important;margin-top:8px!important}.photo-card .full-width{height:36px!important;min-width:100%!important}

/* Sections 4 to 8: remove main boxes and reduce spacing */
.settings-mid-grid,.settings-bottom-grid{
  gap:14px!important;
  margin-bottom:14px!important;
}
.settings-mid-grid>.admin-main-box,
.settings-bottom-grid>.admin-main-box{
  border:0!important;
  box-shadow:none!important;
  background:transparent!important;
  border-radius:0!important;
  padding:10px 6px!important;
}
.settings-mid-grid>.admin-main-box:hover,
.settings-bottom-grid>.admin-main-box:hover{background:transparent!important}
.settings-mid-grid .card-title-row,.settings-bottom-grid .card-title-row{margin-bottom:10px!important}.settings-mid-grid .card-title-row h2,.settings-bottom-grid .card-title-row h2{font-size:16px!important}
.settings-line{min-height:37px!important;font-size:12.5px!important;gap:10px!important}.mini-btn{height:30px!important;min-width:72px!important;font-size:11.5px!important}.settings-toggle{width:40px!important;height:21px!important}.settings-toggle:after{width:15px!important;height:15px!important}.billing-grid{gap:0 18px!important;margin-bottom:12px!important}.billing-grid>div{min-height:44px!important;padding:2px 0 9px!important}.button-pair{gap:10px!important}.button-pair .admin-btn{min-width:0!important;width:100%!important}
.integration-grid{gap:10px!important}.integration-card{min-height:96px!important;padding:10px 8px!important;border:1px solid #e1e6ef!important;background:#fff!important}.integration-logo{height:24px!important}.integration-logo svg{width:23px!important;height:23px!important}.integration-card b{font-size:12.5px!important}.integration-card small{font-size:10.5px!important}.integration-card em{height:28px!important;min-width:86px!important;font-size:11.5px!important}.settings-bottom-grid{grid-template-columns:minmax(0,2fr) minmax(320px,.95fr)!important}

/* Only Section 9 keeps a soft box */
.team-section{
  border:1.4px solid var(--admin-border-soft)!important;
  box-shadow:0 5px 18px rgba(5,8,22,.04)!important;
  border-radius:13px!important;
  background:#fff!important;
}
.team-head{padding:14px 18px 9px!important}.team-table th{height:38px!important;background:#f8fafc!important;padding:0 20px!important;color:#050816!important}.team-table td{height:52px!important;padding:0 20px!important}.table-action-row button{background:#f8fafc!important;color:#050816!important;border:0!important}
.admin-feedback-toast{background:linear-gradient(135deg,#0b63f6,#084ac2)!important;color:#fff!important;box-shadow:0 14px 32px rgba(11,99,246,.28)!important}
@media(max-width:1300px){.settings-top-grid{grid-template-columns:1fr!important}.settings-top-grid .photo-card{border-left:0!important;border-right:0!important;border-top:1px solid #edf1f6!important;border-bottom:1px solid #edf1f6!important;padding:14px 0!important}.settings-bottom-grid{grid-template-columns:1fr!important}}
@media(max-width:820px){.admin-head-actions{width:100%;grid-template-columns:1fr 1fr;min-width:0}.admin-date-control{width:100%!important;min-width:100%!important}.card-save-btn{width:100%!important}}



/* ===== SETTINGS V4: requested order + icon/button polish ===== */
.settings-top-grid{
  grid-template-columns:220px minmax(0,1.42fr) minmax(0,1fr)!important;
  align-items:stretch!important;
  border:1px solid #e3e8f0!important;
  box-shadow:0 4px 14px rgba(5,8,22,.035)!important;
  padding:12px 14px!important;
  gap:12px!important;
}
.settings-top-grid .photo-card{
  order:1!important;
  border-left:0!important;
  border-right:1px solid #edf1f6!important;
  padding:0 14px 0 0!important;
}
.settings-top-grid .profile-card{order:2!important;}
.settings-top-grid .business-card{order:3!important;}
.settings-top-grid .photo-preview-wrap{width:108px!important;height:108px!important;margin:2px auto 10px!important;}
.settings-top-grid .profile-photo-preview{width:108px!important;height:108px!important;}
.settings-top-grid .photo-edit-btn{
  width:28px!important;height:28px!important;right:4px!important;bottom:6px!important;
  background:transparent!important;box-shadow:none!important;color:#0b63f6!important;border:0!important;
}
.settings-top-grid .photo-edit-btn:hover{background:transparent!important;color:#050816!important;transform:none!important;}
.settings-top-grid .photo-edit-btn:hover svg{color:#050816!important;stroke:#050816!important;}
.settings-top-grid .photo-card .full-width{height:38px!important;min-height:38px!important;min-width:136px!important;width:100%!important;}
.settings-top-grid .card-save-btn{height:38px!important;min-height:38px!important;}
.admin-btn,.mini-btn,.integration-card em{
  height:38px!important;min-height:38px!important;border-radius:8px!important;font-size:12.5px!important;
}
.admin-btn{min-width:136px!important;}
.mini-btn{height:30px!important;min-height:30px!important;min-width:78px!important;}
.admin-btn-primary{background:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%)!important;color:#050816!important;}
.admin-btn-outline,.mini-btn,.integration-card em{background:#f8fafc!important;color:#050816!important;}
.card-title-row>svg{color:#0b63f6!important;stroke:#0b63f6!important;}
/* real icon colors copied from Orders reference */
.logo-red svg{color:#ef4444!important;stroke:#ef4444!important;}
.logo-green svg{color:#10b981!important;stroke:#10b981!important;}
.logo-black svg{color:#050816!important;stroke:#050816!important;}
.logo-purple svg{color:#635bff!important;stroke:#635bff!important;}
.logo-cyan svg{color:#0ea5e9!important;stroke:#0ea5e9!important;}
.logo-orange svg{color:#f97316!important;stroke:#f97316!important;}
.toggle-row span svg{color:#475467!important;stroke:#475467!important;}
.toggle-row:hover span svg{color:#0b63f6!important;stroke:#0b63f6!important;}
/* icon-only buttons: no bg hover, color only */
.photo-edit-btn,.table-action-row button{
  background:transparent!important;border:0!important;box-shadow:none!important;
}
.table-action-row button:hover{
  background:transparent!important;color:#0b63f6!important;transform:none!important;
}
.table-action-row button:hover svg{color:#0b63f6!important;stroke:#0b63f6!important;}
.integration-card:hover{background:#fff!important;}
.integration-card:hover .integration-logo svg{filter:brightness(.85);}
.card-title-row:hover,.settings-line span:hover{background:transparent!important;}
@media(max-width:1300px){
 .settings-top-grid{grid-template-columns:1fr!important;}
 .settings-top-grid .photo-card{border-right:0!important;border-bottom:1px solid #edf1f6!important;padding:0 0 12px!important;}
}
</style>


<style id="settings-user-request-final-kbm-dashboard-oval-patch">
/* =========================================================
   SETTINGS FINAL PATCH
   - Knowledge Base Management card color/style
   - No black box hover overlay
   - Dashboard calendar/date function + shape
   - Dashboard button shape/color/style, forced OVAL
   - Section titles use icon + title only; numeric prefixes removed in HTML
========================================================= */
.settings-admin-shell{
    --settings-hc-bg:#F8FBFF;
    --settings-hc-card:#FFFFFF;
    --settings-hc-border:#DDE6F2;
    --settings-hc-shadow:0 10px 25px rgba(15,23,42,.045);
    --settings-hc-radius:14px;
    --settings-blue-gradient:linear-gradient(135deg,#1274ff 0%,#0b63f6 54%,#084ac2 100%);
    background:var(--settings-hc-bg)!important;
    max-width:1320px!important;
    padding:32px 26px 42px!important;
}
.settings-admin-shell .admin-title-line{padding-left:0!important;padding-top:12px!important;}
.settings-admin-shell .admin-title-line:before{left:0!important;top:0!important;width:68px!important;height:4px!important;border-radius:999px!important;background:linear-gradient(90deg,#0B63F6,#4a90ff)!important;}

/* Knowledge Base Management box style for Settings boxes */
.settings-admin-shell .settings-top-grid,
.settings-admin-shell .settings-mid-grid > .admin-main-box,
.settings-admin-shell .settings-bottom-grid > .admin-main-box,
.settings-admin-shell .team-section{
    background:var(--settings-hc-card)!important;
    border:1px solid var(--settings-hc-border)!important;
    border-radius:var(--settings-hc-radius)!important;
    box-shadow:var(--settings-hc-shadow)!important;
    overflow:hidden!important;
}
.settings-admin-shell .settings-mid-grid > .admin-main-box,
.settings-admin-shell .settings-bottom-grid > .admin-main-box{
    padding:18px!important;
}
.settings-admin-shell .settings-top-grid{
    padding:18px!important;
    gap:16px!important;
    margin-bottom:16px!important;
}
.settings-admin-shell .settings-top-grid > .admin-main-box{
    background:transparent!important;
    border:0!important;
    box-shadow:none!important;
    border-radius:0!important;
}
.settings-admin-shell .settings-top-grid .photo-card{
    border-right:1px solid #E7EEF8!important;
    padding-right:16px!important;
}

/* Remove black hover box/overlay effect */
.settings-admin-shell .admin-main-box:hover,
.settings-admin-shell .clickable-main-box:hover,
.settings-admin-shell .settings-top-grid:hover,
.settings-admin-shell .settings-mid-grid > .admin-main-box:hover,
.settings-admin-shell .settings-bottom-grid > .admin-main-box:hover,
.settings-admin-shell .team-section:hover,
.settings-admin-shell .integration-card:hover,
.settings-admin-shell .settings-line:hover,
.settings-admin-shell .toggle-row:hover{
    background:var(--settings-hc-card)!important;
    border-color:var(--settings-hc-border)!important;
    box-shadow:var(--settings-hc-shadow)!important;
    transform:none!important;
    filter:none!important;
}
.settings-admin-shell .settings-top-grid > .admin-main-box:hover,
.settings-admin-shell .settings-top-grid .photo-edit-btn:hover,
.settings-admin-shell .table-action-row button:hover{
    background:transparent!important;
    box-shadow:none!important;
}
.settings-admin-shell .clickable-main-box:after,
.settings-admin-shell .clickable-main-box:hover:after{
    display:none!important;
    opacity:0!important;
    background:transparent!important;
    backdrop-filter:none!important;
}

/* Titles: icon + title only */
.settings-admin-shell .card-title-row h2{
    font-family:'Poppins',system-ui,sans-serif!important;
    font-weight:800!important;
    font-size:17px!important;
    color:#0F172A!important;
}
.settings-admin-shell .card-title-row > i,
.settings-admin-shell .card-title-row > svg{
    color:#0B63F6!important;
    stroke:#0B63F6!important;
}

/* Dashboard-style OVAL buttons */
.settings-admin-shell .admin-btn,
.settings-admin-shell .mini-btn,
.settings-admin-shell .integration-card em,
.settings-admin-shell .settings-calendar-action-btn,
.settings-admin-shell .settings-calendar-save-btn,
.settings-admin-shell .settings-calendar-clear-btn,
.settings-admin-shell .settings-calendar-mini-btn{
    border-radius:9999px!important;
    border:0!important;
    box-shadow:0 10px 22px rgba(11,99,246,.16)!important;
    background:var(--settings-blue-gradient)!important;
    background-image:var(--settings-blue-gradient)!important;
    color:#FFFFFF!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-weight:700!important;
    transition:background .18s ease,color .18s ease,box-shadow .18s ease!important;
}
.settings-admin-shell .admin-btn svg,
.settings-admin-shell .mini-btn svg,
.settings-admin-shell .integration-card em svg,
.settings-admin-shell .settings-calendar-action-btn svg,
.settings-admin-shell .settings-calendar-save-btn svg,
.settings-admin-shell .settings-calendar-clear-btn svg,
.settings-admin-shell .settings-calendar-mini-btn svg{
    color:#FFFFFF!important;
    stroke:#FFFFFF!important;
}
.settings-admin-shell .admin-btn:hover,
.settings-admin-shell .mini-btn:hover,
.settings-admin-shell .integration-card:hover em,
.settings-admin-shell .settings-calendar-action-btn:hover,
.settings-admin-shell .settings-calendar-save-btn:hover,
.settings-admin-shell .settings-calendar-clear-btn:hover,
.settings-admin-shell .settings-calendar-mini-btn:hover{
    background:#111827!important;
    background-image:none!important;
    color:#FFFFFF!important;
    box-shadow:0 10px 22px rgba(17,24,39,.18)!important;
    transform:none!important;
}
.settings-admin-shell .admin-btn:hover svg,
.settings-admin-shell .mini-btn:hover svg,
.settings-admin-shell .settings-calendar-action-btn:hover svg,
.settings-admin-shell .settings-calendar-save-btn:hover svg,
.settings-admin-shell .settings-calendar-clear-btn:hover svg,
.settings-admin-shell .settings-calendar-mini-btn:hover svg{
    color:#FFFFFF!important;
    stroke:#FFFFFF!important;
}
.settings-admin-shell .admin-btn{
    height:40px!important;
    min-height:40px!important;
    min-width:128px!important;
    padding:0 18px!important;
}
.settings-admin-shell .mini-btn{
    height:32px!important;
    min-height:32px!important;
    min-width:76px!important;
    padding:0 13px!important;
}
.settings-admin-shell .button-pair .admin-btn,
.settings-admin-shell .card-save-btn,
.settings-admin-shell .photo-card .full-width{
    width:100%!important;
}
.settings-admin-shell .card-save-btn{max-width:220px!important;margin-left:auto!important;}

/* Dashboard-style date/calendar pill */
.settings-admin-shell .admin-head-actions{
    display:grid!important;
    grid-template-columns:128px 150px!important;
    grid-template-areas:"date date" "export save"!important;
    gap:9px!important;
    justify-content:end!important;
    justify-items:stretch!important;
    min-width:288px!important;
}
.settings-admin-shell .admin-date-control{
    grid-area:date!important;
    width:100%!important;
    min-width:286px!important;
    height:42px!important;
    min-height:42px!important;
    padding:0 16px!important;
    border:1px solid #D8DEE8!important;
    border-radius:9999px!important;
    background:#FFFFFF!important;
    background-image:none!important;
    color:#050816!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    gap:10px!important;
    box-shadow:none!important;
    font-family:'Poppins',system-ui,sans-serif!important;
    font-size:12px!important;
    font-weight:700!important;
}
.settings-admin-shell .admin-date-control svg{color:#050816!important;stroke:#050816!important;}
.settings-admin-shell .admin-date-control svg:first-child{color:#0B63F6!important;stroke:#0B63F6!important;}
.settings-admin-shell .admin-date-control:hover,
.settings-admin-shell .admin-date-control:focus{
    background:#111827!important;
    border-color:#111827!important;
    color:#FFFFFF!important;
    transform:none!important;
}
.settings-admin-shell .admin-date-control:hover svg,
.settings-admin-shell .admin-date-control:focus svg{color:#FFFFFF!important;stroke:#FFFFFF!important;}
.settings-admin-shell #settingsExportBtn,
.settings-admin-shell .admin-head-actions .admin-btn-outline{grid-area:export!important;}
.settings-admin-shell .admin-head-actions .admin-btn-primary{grid-area:save!important;}

/* Calendar modal copied to Dashboard direction */
body.settings-calendar-lock{overflow:hidden!important;}
.settings-calendar-overlay{
    position:fixed!important;
    inset:0!important;
    z-index:6900!important;
    display:flex;
    align-items:center!important;
    justify-content:center!important;
    padding:18px!important;
    background:rgba(17,24,39,.36)!important;
    backdrop-filter:blur(9px)!important;
    -webkit-backdrop-filter:blur(9px)!important;
}
.settings-calendar-modal{
    width:min(980px,calc(100vw - 48px))!important;
    max-height:calc(100vh - 42px)!important;
    overflow:hidden!important;
    border:1.2px solid #111827!important;
    border-radius:18px!important;
    background:#FFFFFF!important;
    box-shadow:0 26px 80px rgba(15,23,42,.22)!important;
    display:grid!important;
    grid-template-columns:minmax(0,650px) 330px!important;
    color:#111827!important;
}
.settings-calendar-main{padding:18px 18px 20px!important;border-right:1px solid #E8EDF5!important;min-width:0!important;background:#FFFFFF!important;}
.settings-calendar-side{padding:18px!important;background:#FFFFFF!important;min-width:0!important;}
.settings-calendar-headline{display:grid!important;grid-template-columns:minmax(160px,1fr) auto 34px!important;gap:14px!important;align-items:start!important;margin-bottom:16px!important;}
.settings-calendar-intro h3{margin:0 0 3px!important;font-family:'Poppins',system-ui,sans-serif!important;font-size:16px!important;font-weight:700!important;color:#111827!important;line-height:1.2!important;}
.settings-calendar-intro p{width:160px!important;margin:0!important;font-size:11px!important;font-weight:400!important;line-height:1.45!important;color:#6B7280!important;}
.settings-calendar-nav-main{display:flex;align-items:center!important;justify-content:center!important;gap:38px!important;padding-top:8px!important;}
.settings-calendar-monthbar{display:flex;align-items:center!important;justify-content:space-between!important;gap:12px!important;margin-bottom:12px!important;}
.settings-calendar-title,.settings-calendar-selected-date{margin:0!important;font-family:'Poppins',system-ui,sans-serif!important;font-size:16px!important;font-weight:700!important;color:#111827!important;letter-spacing:0!important;}
.settings-calendar-icon-btn{
    width:34px!important;height:34px!important;min-width:34px!important;padding:0!important;border:0!important;border-radius:9999px!important;background:#FFFFFF!important;color:#111827!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;box-shadow:none!important;cursor:pointer!important;
}
.settings-calendar-icon-btn svg,.settings-calendar-icon-btn i{width:20px!important;height:20px!important;stroke-width:2.2!important;}
.settings-calendar-icon-btn:hover{background:#F4F6F9!important;color:#111827!important;box-shadow:none!important;}
.settings-calendar-action-btn,.settings-calendar-clear-btn,.settings-calendar-save-btn{height:36px!important;min-height:36px!important;padding:0 18px!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:7px!important;}
.settings-calendar-weekdays,.settings-calendar-grid{display:grid!important;grid-template-columns:repeat(7,minmax(0,1fr))!important;gap:7px!important;}
.settings-calendar-weekdays{margin-bottom:7px!important;}
.settings-calendar-weekdays span{text-align:center!important;font-size:9.5px!important;font-weight:800!important;color:#6B7280!important;letter-spacing:.08em!important;text-transform:uppercase!important;}
.settings-calendar-day{min-height:78px!important;border:1px solid #E8EDF5!important;border-radius:12px!important;background:#FFFFFF!important;padding:8px!important;text-align:left!important;color:#111827!important;box-shadow:none!important;cursor:pointer!important;overflow:hidden!important;}
.settings-calendar-day:hover,.settings-calendar-day:focus{border-color:#0B63F6!important;box-shadow:0 10px 24px rgba(11,99,246,.10)!important;}
.settings-calendar-day.is-muted{background:#FAFAFA!important;color:#A1A1AA!important;}
.settings-calendar-day.is-today{border-color:#0B63F6!important;background:#F7FBFF!important;}
.settings-calendar-day.is-selected{border-color:#111827!important;background:rgba(17,24,39,.08)!important;box-shadow:inset 0 0 0 1px #111827!important;}
.settings-calendar-day-number{display:block!important;font-size:12px!important;font-weight:800!important;line-height:1!important;}
.settings-calendar-day-events{display:flex!important;flex-wrap:wrap!important;gap:4px!important;margin-top:17px!important;}
.settings-calendar-event-dot{width:7px!important;height:7px!important;border-radius:999px!important;background:#0B63F6!important;box-shadow:0 0 0 3px rgba(11,99,246,.10)!important;}
.settings-calendar-more{font-size:9px!important;font-weight:700!important;color:#6B7280!important;line-height:1!important;}
.settings-calendar-selected-date{margin:0 0 14px!important;}
.settings-calendar-event-list{display:grid!important;gap:8px!important;max-height:176px!important;overflow:auto!important;padding-right:2px!important;margin-bottom:12px!important;}
.settings-calendar-event-item{border:1px solid #E8EDF5!important;border-radius:12px!important;background:#FFFFFF!important;padding:10px!important;display:grid!important;gap:7px!important;}
.settings-calendar-event-title{font-size:12px!important;font-weight:800!important;color:#111827!important;line-height:1.3!important;}
.settings-calendar-event-meta{font-size:10px!important;font-weight:600!important;color:#0B63F6!important;line-height:1.35!important;}
.settings-calendar-event-note{font-size:10.5px!important;font-weight:400!important;color:#6B7280!important;line-height:1.45!important;}
.settings-calendar-event-actions{display:flex!important;gap:6px!important;justify-content:flex-end!important;}
.settings-calendar-mini-btn{height:27px!important;min-height:27px!important;padding:0 10px!important;font-size:9.5px!important;box-shadow:none!important;}
.settings-calendar-mini-btn.danger{background:#EF4444!important;background-image:none!important;color:#FFFFFF!important;}
.settings-calendar-empty{min-height:74px!important;border:1px dashed #D8DEE8!important;border-radius:12px!important;display:grid!important;place-items:center!important;text-align:center!important;color:#6B7280!important;font-size:11px!important;font-weight:400!important;line-height:1.45!important;padding:12px!important;background:#FFFFFF!important;margin-bottom:12px!important;}
.settings-calendar-form{display:grid!important;gap:10px!important;}
.settings-calendar-field{display:grid!important;gap:5px!important;}
.settings-calendar-field span{font-size:10px!important;font-weight:800!important;color:#4B5563!important;letter-spacing:.05em!important;text-transform:uppercase!important;}
.settings-calendar-field input,.settings-calendar-field textarea{width:100%!important;border:1px solid #E8EDF5!important;border-radius:10px!important;background:#FFFFFF!important;padding:10px 11px!important;color:#111827!important;font-size:12px!important;font-weight:500!important;outline:none!important;box-shadow:none!important;}
.settings-calendar-field textarea{min-height:68px!important;resize:vertical!important;}
.settings-calendar-field input:focus,.settings-calendar-field textarea:focus{border-color:#0B63F6!important;box-shadow:0 0 0 3px rgba(11,99,246,.10)!important;}
.settings-calendar-form-actions{display:flex;align-items:center!important;justify-content:flex-end!important;gap:8px!important;margin-top:0!important;}
.settings-calendar-clear-btn{width:92px!important;min-width:92px!important;background:#FFFFFF!important;background-image:none!important;color:#111827!important;border:1px solid #E8EDF5!important;box-shadow:none!important;}
.settings-calendar-save-btn{width:124px!important;min-width:124px!important;}
@media(max-width:920px){
    .settings-calendar-modal{grid-template-columns:1fr!important;width:min(720px,calc(100vw - 32px))!important;overflow:auto!important;}
    .settings-calendar-main{border-right:0!important;border-bottom:1px solid #E8EDF5!important;}
    .settings-calendar-headline{grid-template-columns:1fr auto!important;}
    .settings-calendar-nav-main{grid-column:1 / -1!important;justify-content:space-between!important;gap:12px!important;}
}
@media(max-width:1300px){
    .settings-admin-shell .settings-top-grid{grid-template-columns:1fr!important;}
    .settings-admin-shell .settings-top-grid .photo-card{border-right:0!important;border-bottom:1px solid #E7EEF8!important;padding:0 0 16px!important;}
}
@media(max-width:820px){
    .settings-admin-shell .admin-head-actions{width:100%!important;grid-template-columns:1fr 1fr!important;min-width:0!important;}
    .settings-admin-shell .admin-date-control{width:100%!important;min-width:0!important;grid-column:1 / -1!important;}
    .settings-admin-shell .admin-btn{min-width:0!important;width:100%!important;}
}
</style>
