<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RSAA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #68D391;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #68D391;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Top Bar -->
    <div class="bg-gray-900 text-white p-4 flex justify-between items-center sticky top-0 z-50">
        <h1 class="text-xl font-bold tracking-widest text-[#D4AF37]">RSAA ADMIN</h1>
        <div class="flex items-center gap-4">
            <a href="../" target="_blank" class="text-sm text-gray-400 hover:text-white"><i class="fas fa-external-link-alt"></i> View Site</a>
            <button onclick="logout()" class="bg-red-600 px-4 py-2 rounded text-xs font-bold uppercase tracking-widest hover:bg-red-700">Logout</button>
        </div>
    </div>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="flex gap-6 items-start">
            
            <!-- Sidebar -->
            <div class="w-64 bg-white rounded-lg shadow-lg sticky top-24 hidden md:block shrink-0">
                <nav class="p-4 space-y-2">
                    <button onclick="showTab('inquiries')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium active-tab border-l-4 border-[#D4AF37]">
                        <i class="fas fa-inbox w-5"></i> Inquiries
                    </button>
                    <button onclick="showTab('hero')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-home w-5"></i> Hero & Marquee
                    </button>
                    <button onclick="showTab('services')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-briefcase w-5"></i> Services
                    </button>
                    <button onclick="showTab('testimonials')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-quote-left w-5"></i> Testimonials
                    </button>
                    <button onclick="showTab('stats')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-chart-bar w-5"></i> Statistics
                    </button>
                    <button onclick="showTab('blogs')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-newspaper w-5"></i> Blog Posts
                    </button>
                    <button onclick="showTab('contact')" class="tab-btn w-full text-left px-4 py-3 rounded hover:bg-gray-50 text-gray-700 font-medium border-l-4 border-transparent">
                        <i class="fas fa-address-book w-5"></i> Contact Info
                    </button>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 space-y-6 w-full">
                
                <!-- Loading State -->
                <div id="loading" class="text-center py-20">
                    <i class="fas fa-spinner fa-spin text-4xl text-[#D4AF37]"></i>
                    <p class="mt-4 text-gray-500">Loading website data...</p>
                </div>

                <!-- Inquiries Tab with Resolution Feature -->
                <div id="tab-inquiries" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between items-center mb-6 border-b pb-4">
                            <h2 class="text-xl font-bold text-gray-800">Client Inquiries</h2>
                            <a href="../api.php?action=download_inquiries" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded text-xs uppercase font-bold hover:bg-green-700 shadow flex items-center gap-2">
                                <i class="fas fa-file-excel"></i> Download Excel
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Name / Phone</th>
                                        <th class="px-4 py-3">Details</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3 text-center">Resolved?</th>
                                        <th class="px-4 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="inquiries_table_body">
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form id="dashboardForm" class="hidden" onsubmit="saveData(event)">
                    
                    <!-- Hero Section -->
                    <div id="tab-hero" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Hero Section</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Title Line 1</label><input type="text" name="hero_title_1" id="hero_title_1" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Title Line 2</label><input type="text" name="hero_title_2" id="hero_title_2" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Title Line 3</label><input type="text" name="hero_title_3" id="hero_title_3" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                            </div>
                            <div class="mb-4"><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Subtitle</label><textarea name="hero_subtitle" id="hero_subtitle" rows="3" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></textarea></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Top Status Text</label><input type="text" name="hero_status" id="hero_status" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Card Score %</label><input type="text" name="hero_score" id="hero_score" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Marquee Text</h2>
                            <textarea id="marquee_items" rows="4" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></textarea>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div id="tab-services" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                <h2 class="text-xl font-bold text-gray-800">Services Categories</h2>
                                <button type="button" onclick="addServiceCategory()" class="bg-[#D4AF37] text-white px-4 py-2 rounded text-xs uppercase font-bold hover:bg-[#c5a059]"><i class="fas fa-plus-circle mr-1"></i> Add Category</button>
                            </div>
                            <div id="services_container" class="space-y-8"></div>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div id="tab-stats" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Company Statistics</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">% Digital</label><input type="number" id="stats_digital" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Clients Onboarded</label><input type="number" id="stats_clients" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filings Done</label><input type="number" id="stats_filings" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">% Success Rate</label><input type="number" id="stats_success" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonials -->
                    <div id="tab-testimonials" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                <h2 class="text-xl font-bold text-gray-800">Voice of Trust</h2>
                                <button type="button" onclick="addTestimonial()" class="bg-[#D4AF37] text-white px-3 py-1 rounded text-xs uppercase font-bold hover:bg-[#c5a059]">Add New</button>
                            </div>
                            <div id="testimonials_container" class="space-y-6"></div>
                        </div>
                    </div>

                    <!-- Blogs -->
                    <div id="tab-blogs" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow mb-6 border-l-4 border-blue-500">
                            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Insights Page Header</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Small Tagline</label><input type="text" id="insights_tagline" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Headline (Line 1)</label><input type="text" id="insights_title_1" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Headline (Line 2 - Italic)</label><input type="text" id="insights_title_2" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                            </div>
                            <div class="mb-4"><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Description</label><textarea id="insights_desc" rows="2" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></textarea></div>
                            <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Yellow Ticker Text</label><input type="text" id="insights_ticker" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none bg-yellow-50"></div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                <h2 class="text-xl font-bold text-gray-800">Blog Posts</h2>
                                <button type="button" onclick="addBlogPost()" class="bg-[#D4AF37] text-white px-3 py-1 rounded text-xs uppercase font-bold hover:bg-[#c5a059]">Add New</button>
                            </div>
                            <div id="blogs_container" class="space-y-6"></div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div id="tab-contact" class="tab-content hidden space-y-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Contact Information</h2>
                            <div class="grid grid-cols-1 gap-4">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone Number</label><input type="text" id="contact_phone" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">WhatsApp Number (e.g. 919876543210)</label><input type="text" id="contact_whatsapp" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none" placeholder="Enter number without + or spaces"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email Address</label><input type="text" id="contact_email" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Office Address</label><input type="text" id="contact_address" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Google Maps Embed URL</label><textarea id="contact_map" rows="3" class="w-full border p-2 rounded focus:border-[#D4AF37] outline-none font-mono text-xs"></textarea></div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Action -->
                    <div class="fixed bottom-6 right-6 z-50">
                        <button type="submit" class="bg-green-600 text-white px-8 py-4 rounded-full shadow-2xl font-bold text-lg hover:bg-green-700 transition-all transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        let currentData = {};

        // Fetch Data on Load
        window.addEventListener('DOMContentLoaded', async () => {
            await loadWebsiteData();
            await loadInquiries();
        });

        async function loadWebsiteData() {
            try {
                const response = await fetch('../api.php?action=get_data');
                const data = await response.json();
                currentData = data;
                
                // Initialize arrays if missing
                if(!currentData.blogs) currentData.blogs = [];
                if(!currentData.testimonials) currentData.testimonials = [];
                if(!currentData.services) currentData.services = [];
                if(!currentData.insights) currentData.insights = {};

                populateForm(data);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('tab-inquiries').classList.remove('hidden');
            } catch (error) {
                console.error(error);
            }
        }

        async function loadInquiries() {
            try {
                const response = await fetch('../api.php?action=get_inquiries');
                const inquiries = await response.json();
                const tbody = document.getElementById('inquiries_table_body');
                tbody.innerHTML = '';

                if(inquiries.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-4 py-4 text-center">No inquiries yet.</td></tr>';
                    return;
                }

                inquiries.forEach(inq => {
                    const urgencyClass = (inq.urgency === 'URGENT / NOTICE') ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800';
                    const resolvedClass = inq.resolved ? 'line-through text-gray-400' : '';
                    const checked = inq.resolved ? 'checked' : '';

                    const html = `
                        <tr class="bg-white border-b hover:bg-gray-50 ${resolvedClass}">
                            <td class="px-4 py-3">${inq.timestamp.split(' ')[0]}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 ${resolvedClass}">${inq.name}<br><span class="text-xs text-gray-500">${inq.phone}</span></td>
                            <td class="px-4 py-3">${inq.service}<br><span class="text-xs text-gray-400">Via ${inq.mode}</span></td>
                            <td class="px-4 py-3"><span class="${urgencyClass} text-xs font-medium px-2.5 py-0.5 rounded">${inq.urgency}</span></td>
                            <td class="px-4 py-3 text-center">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" ${checked} onchange="toggleResolved('${inq.id}', this.checked)">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                </label>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewMessage('${encodeURIComponent(inq.message)}')" class="text-blue-600 hover:underline text-xs mr-2">View Msg</button>
                                <button onclick="deleteInquiry('${inq.id}')" class="text-red-600 hover:text-red-900 text-xs"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', html);
                });
            } catch (err) {
                console.error(err);
            }
        }

        async function deleteInquiry(id) {
            Swal.fire({
                title: 'Delete Inquiry?',
                text: "This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch('../api.php?action=delete_inquiry', {
                            method: 'POST',
                            body: JSON.stringify({ id: id })
                        });
                        const data = await res.json();
                        if(data.success) {
                            Swal.fire('Deleted!', 'Inquiry removed.', 'success');
                            loadInquiries();
                        } else {
                            Swal.fire('Error', 'Failed to delete.', 'error');
                        }
                    } catch (e) {
                        console.error(e);
                        Swal.fire('Error', 'Network error.', 'error');
                    }
                }
            })
        }

        async function toggleResolved(id, status) {
            try {
                await fetch('../api.php?action=update_inquiry_status', {
                    method: 'POST',
                    body: JSON.stringify({ id: id, resolved: status })
                });
                await loadInquiries();
            } catch (e) {
                console.error("Failed to update status", e);
            }
        }

        function viewMessage(msg) {
            Swal.fire({ title: 'Client Message', text: decodeURIComponent(msg) });
        }

        function populateForm(data) {
            // Hero
            document.getElementById('hero_title_1').value = data.hero.title_line_1;
            document.getElementById('hero_title_2').value = data.hero.title_line_2;
            document.getElementById('hero_title_3').value = data.hero.title_line_3;
            document.getElementById('hero_subtitle').value = data.hero.subtitle;
            document.getElementById('hero_status').value = data.hero.status_text;
            document.getElementById('hero_score').value = data.hero.compliance_score;
            document.getElementById('marquee_items').value = data.marquee.join(', ');

            // Stats
            document.getElementById('stats_digital').value = data.stats.digital_percent;
            document.getElementById('stats_clients').value = data.stats.clients;
            document.getElementById('stats_filings').value = data.stats.filings;
            document.getElementById('stats_success').value = data.stats.success_rate;

            // Insights
            if(data.insights) {
                document.getElementById('insights_tagline').value = data.insights.tagline || '';
                document.getElementById('insights_title_1').value = data.insights.title_line_1 || '';
                document.getElementById('insights_title_2').value = data.insights.title_line_2 || '';
                document.getElementById('insights_desc').value = data.insights.description || '';
                document.getElementById('insights_ticker').value = data.insights.ticker || '';
            }

            // Contact
            if(data.contact_info) {
                document.getElementById('contact_phone').value = data.contact_info.phone || '';
                document.getElementById('contact_whatsapp').value = data.contact_info.whatsapp || '';
                document.getElementById('contact_email').value = data.contact_info.email || '';
                document.getElementById('contact_address').value = data.contact_info.address || '';
                document.getElementById('contact_map').value = data.contact_info.map_url || '';
            }

            renderServices();
            renderBlogs();
            renderTestimonials();
        }

        // --- SERVICES RENDER LOGIC ---
        function renderServices() {
            const container = document.getElementById('services_container');
            container.innerHTML = '';
            
            if(!Array.isArray(currentData.services)) currentData.services = []; 

            currentData.services.forEach((cat, catIndex) => {
                let cardsHtml = '';
                cat.cards.forEach((card, cardIndex) => {
                    const itemsText = card.items ? card.items.join('\n') : '';
                    cardsHtml += `
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded mb-4 relative">
                            <button type="button" onclick="removeCard(${catIndex}, ${cardIndex})" class="absolute top-2 right-2 text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
                            <div class="mb-2"><label class="block text-xs font-bold text-gray-500 uppercase">Card Title</label><input type="text" value="${card.title}" onchange="updateCard(${catIndex}, ${cardIndex}, 'title', this.value)" class="w-full border p-1 rounded"></div>
                            <div><label class="block text-xs font-bold text-gray-500 uppercase">List Items (One per line)</label><textarea rows="4" onchange="updateCardItems(${catIndex}, ${cardIndex}, this.value)" class="w-full border p-1 rounded text-sm">${itemsText}</textarea></div>
                        </div>
                    `;
                });

                const html = `
                    <div class="bg-white border-2 border-gray-100 rounded-xl overflow-hidden shadow-sm relative group">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex-1 mr-4">
                                <label class="block text-xs font-bold text-[#D4AF37] uppercase mb-1">Category Name</label>
                                <input type="text" value="${cat.name}" onchange="updateCategory(${catIndex}, 'name', this.value)" class="text-lg font-serif font-bold w-full bg-transparent border-b border-dashed border-gray-300 focus:border-[#D4AF37] outline-none">
                            </div>
                            <div class="flex items-center gap-2"><button type="button" onclick="removeCategory(${catIndex})" class="text-red-500 hover:bg-red-50 p-2 rounded transition-colors"><i class="fas fa-trash-alt"></i> Delete</button></div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Service Cards</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                ${cardsHtml}
                                <button type="button" onclick="addCard(${catIndex})" class="border-2 border-dashed border-gray-300 rounded p-4 flex flex-col items-center justify-center text-gray-400 hover:border-[#D4AF37] hover:text-[#D4AF37] transition-colors min-h-[200px]"><i class="fas fa-plus text-2xl mb-2"></i><span class="text-sm font-bold uppercase">Add Card</span></button>
                            </div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        // Functions for Services
        function addServiceCategory() { currentData.services.push({ id: 'new_'+Date.now(), name: 'New Category', cards: [] }); renderServices(); }
        function removeCategory(i) { Swal.fire({ title: 'Delete?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes' }).then((r) => { if(r.isConfirmed){ currentData.services.splice(i,1); renderServices(); } }); }
        function updateCategory(i, f, v) { currentData.services[i][f] = v; if(f==='name') currentData.services[i].id = v.toLowerCase().replace(/[^a-z0-9]/g,''); }
        function addCard(i) { currentData.services[i].cards.push({ title: 'New Service', items: [] }); renderServices(); }
        function removeCard(ci, cdi) { currentData.services[ci].cards.splice(cdi, 1); renderServices(); }
        function updateCard(ci, cdi, f, v) { currentData.services[ci].cards[cdi][f] = v; }
        function updateCardItems(ci, cdi, v) { currentData.services[ci].cards[cdi].items = v.split('\n').filter(s=>s.trim()!==''); }

        // --- BLOGS ---
        function renderBlogs() {
            const container = document.getElementById('blogs_container');
            container.innerHTML = '';
            currentData.blogs.forEach((blog, index) => {
                const html = `
                    <div class="border border-gray-200 rounded p-4 relative bg-gray-50">
                        <button type="button" onclick="removeBlog(${index})" class="absolute top-2 right-2 text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-gray-500 mb-1">Title</label><input type="text" value="${blog.title}" onchange="updateBlog(${index}, 'title', this.value)" class="w-full border p-2 rounded bg-white"></div>
                            <div><label class="block text-xs font-bold text-gray-500 mb-1">Date</label><input type="text" value="${blog.date}" onchange="updateBlog(${index}, 'date', this.value)" class="w-full border p-2 rounded bg-white"></div>
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-500 mb-1">Category</label><input type="text" value="${blog.category}" onchange="updateBlog(${index}, 'category', this.value)" class="w-full border p-2 rounded bg-white"></div>
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-500 mb-1">Image URL</label><div class="flex gap-2"><input type="text" value="${blog.image}" id="blog_img_${index}" onchange="updateBlog(${index}, 'image', this.value)" class="w-full border p-2 rounded bg-white"><label class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded text-xs font-bold uppercase hover:bg-blue-700"><i class="fas fa-upload"></i><input type="file" class="hidden" onchange="uploadImage(this, ${index}, 'blog')"></label></div></div>
                             <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-500 mb-1">Excerpt</label><textarea rows="2" onchange="updateBlog(${index}, 'excerpt', this.value)" class="w-full border p-2 rounded bg-white">${blog.excerpt}</textarea></div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', html);
            });
        }
        function updateBlog(i, f, v) { currentData.blogs[i][f] = v; }
        function removeBlog(i) { Swal.fire({ title: 'Delete?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes' }).then((r) => { if(r.isConfirmed){ currentData.blogs.splice(i,1); renderBlogs(); } }); }
        function addBlogPost() { currentData.blogs.unshift({ id: Date.now(), title: "New Blog", date: new Date().toLocaleDateString('en-US'), category: "News", excerpt: "...", image: "https://placehold.co/800x600" }); renderBlogs(); }

        // --- TESTIMONIALS ---
        function renderTestimonials() {
            const container = document.getElementById('testimonials_container');
            container.innerHTML = '';
            currentData.testimonials.forEach((item, index) => {
                const html = `
                    <div class="border border-gray-200 rounded p-4 relative bg-gray-50">
                        <button type="button" onclick="removeTestimonial(${index})" class="absolute top-2 right-2 text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                        <div class="grid grid-cols-1 gap-4">
                            <div><label class="block text-xs font-bold text-gray-500 mb-1">Quote</label><textarea rows="3" onchange="updateTestimonial(${index}, 'quote', this.value)" class="w-full border p-2 rounded bg-white">${item.quote}</textarea></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-xs font-bold text-gray-500 mb-1">Name</label><input type="text" value="${item.author}" onchange="updateTestimonial(${index}, 'author', this.value)" class="w-full border p-2 rounded bg-white"></div>
                                <div><label class="block text-xs font-bold text-gray-500 mb-1">Designation</label><input type="text" value="${item.designation}" onchange="updateTestimonial(${index}, 'designation', this.value)" class="w-full border p-2 rounded bg-white"></div>
                            </div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', html);
            });
        }
        function updateTestimonial(i, f, v) { currentData.testimonials[i][f] = v; }
        function removeTestimonial(i) { Swal.fire({ title: 'Delete?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes' }).then((r) => { if(r.isConfirmed){ currentData.testimonials.splice(i,1); renderTestimonials(); } }); }
        function addTestimonial() { currentData.testimonials.push({ quote: "Great work!", author: "Client", designation: "CEO" }); renderTestimonials(); }

        // --- SHARED ---
        async function uploadImage(input, index, type) {
            if (!input.files[0]) return;
            const formData = new FormData(); formData.append('image', input.files[0]);
            try {
                const res = await fetch('../api.php?action=upload_image', { method: 'POST', body: formData });
                const result = await res.json();
                if (result.success) {
                    if(type==='blog') { currentData.blogs[index].image = result.data.url; document.getElementById(`blog_img_${index}`).value = result.data.url; }
                    Swal.fire('Success', 'Uploaded', 'success');
                }
            } catch(e) { Swal.fire('Error', 'Upload failed', 'error'); }
        }

        async function saveData(e) {
            e.preventDefault();
            // Basic Fields
            currentData.hero.title_line_1 = document.getElementById('hero_title_1').value;
            currentData.hero.title_line_2 = document.getElementById('hero_title_2').value;
            currentData.hero.title_line_3 = document.getElementById('hero_title_3').value;
            currentData.hero.subtitle = document.getElementById('hero_subtitle').value;
            currentData.hero.status_text = document.getElementById('hero_status').value;
            currentData.hero.compliance_score = document.getElementById('hero_score').value;
            currentData.marquee = document.getElementById('marquee_items').value.split(',').map(s=>s.trim()).filter(s=>s);
            
            currentData.stats.digital_percent = document.getElementById('stats_digital').value;
            currentData.stats.clients = document.getElementById('stats_clients').value;
            currentData.stats.filings = document.getElementById('stats_filings').value;
            currentData.stats.success_rate = document.getElementById('stats_success').value;

            if(!currentData.insights) currentData.insights = {};
            currentData.insights.tagline = document.getElementById('insights_tagline').value;
            currentData.insights.title_line_1 = document.getElementById('insights_title_1').value;
            currentData.insights.title_line_2 = document.getElementById('insights_title_2').value;
            currentData.insights.description = document.getElementById('insights_desc').value;
            currentData.insights.ticker = document.getElementById('insights_ticker').value;

            currentData.contact_info.phone = document.getElementById('contact_phone').value;
            currentData.contact_info.whatsapp = document.getElementById('contact_whatsapp').value;
            currentData.contact_info.email = document.getElementById('contact_email').value;
            currentData.contact_info.address = document.getElementById('contact_address').value;
            currentData.contact_info.map_url = document.getElementById('contact_map').value;

            try {
                const res = await fetch('../api.php?action=save_data', { method: 'POST', body: JSON.stringify(currentData) });
                const result = await res.json();
                if (result.success) Swal.fire('Saved!', 'Website updated.', 'success');
                else Swal.fire('Error', result.message, 'error');
            } catch (err) { Swal.fire('Error', 'Connection failed.', 'error'); }
        }

        async function logout() { await fetch('../api.php?action=logout'); window.location.href = 'index.php'; }
        
        function showTab(id) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + id).classList.remove('hidden');
            
            if(id === 'inquiries') {
                document.getElementById('dashboardForm').classList.add('hidden');
            } else {
                document.getElementById('dashboardForm').classList.remove('hidden');
            }

            document.querySelectorAll('.tab-btn').forEach(el => { el.classList.remove('border-[#D4AF37]', 'bg-gray-50', 'border-transparent'); el.classList.add('border-transparent'); });
            event.target.closest('.tab-btn').classList.remove('border-transparent'); 
            event.target.closest('.tab-btn').classList.add('border-[#D4AF37]', 'bg-gray-50');
        }
    </script>
</body>
</html>