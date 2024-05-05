<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card app-calendar-wrapper">
        <div class="row g-0">
            <!-- Calendar Sidebar -->
            <div class="col app-calendar-sidebar pt-1" id="app-calendar-sidebar">
                <div class="p-4">
                    <!-- inline calendar (flatpicker) -->
                    <div class="inline-calendar"></div>

                    <hr class="container-m-nx my-4" />

                    <!-- Filter -->
                    <div class="mb-4">
                        <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                    </div>

                    <div class="form-check form-check-secondary mb-3">
                        <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all"
                            checked />
                        <label class="form-check-label" for="selectAll">View All</label>
                    </div>

                    <div class="app-calendar-events-filter">
                        <div class="form-check form-check-danger mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                data-value="personal" checked />
                            <label class="form-check-label" for="select-personal">Personal</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                data-value="business" checked />
                            <label class="form-check-label" for="select-business">Business</label>
                        </div>
                        <div class="form-check form-check-warning mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-family"
                                data-value="family" checked />
                            <label class="form-check-label" for="select-family">Family</label>
                        </div>
                        <div class="form-check form-check-success mb-3">
                            <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                data-value="holiday" checked />
                            <label class="form-check-label" for="select-holiday">Holiday</label>
                        </div>
                        <div class="form-check form-check-info">
                            <input class="form-check-input input-filter" type="checkbox" id="select-etc"
                                data-value="etc" checked />
                            <label class="form-check-label" for="select-etc">ETC</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Calendar Sidebar -->

            <!-- Calendar & Modal -->
            <div class="col app-calendar-content">
                <div class="card shadow-none border-0 border-start rounded-0">
                    <div class="card-body pb-0">
                        <!-- FullCalendar -->
                        <div id="calendar"></div>
                    </div>
                </div>
                <div class="app-overlay"></div>
            </div>
            <!-- /Calendar & Modal -->
        </div>
    </div>
</div>
<!-- / Content -->
<script>
    var date = new Date();
    var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
    // prettier-ignore
    var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date
        .getMonth() + 1, 1);
    // prettier-ignore
    var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date
        .getMonth() - 1, 1);

    var events = [{
            id: 1,
            url: '',
            title: 'Design Review',
            start: date,
            end: nextDay,
            allDay: false,
            extendedProps: {
                calendar: 'Business'
            }
        },
        {
            id: 2,
            url: '',
            title: 'Meeting With Client',
            start: new Date(date.getFullYear(), date.getMonth() + 1, -11),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -10),
            allDay: true,
            extendedProps: {
                calendar: 'Business'
            }
        },
        {
            id: 3,
            url: '',
            title: 'Family Trip',
            allDay: true,
            start: new Date(date.getFullYear(), date.getMonth() + 1, -9),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -7),
            extendedProps: {
                calendar: 'Holiday'
            }
        },
        {
            id: 4,
            url: '',
            title: "Doctor's Appointment",
            start: new Date(date.getFullYear(), date.getMonth() + 1, -11),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -10),
            extendedProps: {
                calendar: 'Personal'
            }
        },
        {
            id: 5,
            url: '',
            title: 'Dart Game?',
            start: new Date(date.getFullYear(), date.getMonth() + 1, -13),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -12),
            allDay: true,
            extendedProps: {
                calendar: 'ETC'
            }
        },
        {
            id: 6,
            url: '',
            title: 'Meditation',
            start: new Date(date.getFullYear(), date.getMonth() + 1, -13),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -12),
            allDay: true,
            extendedProps: {
                calendar: 'Personal'
            }
        },
        {
            id: 7,
            url: '',
            title: 'Dinner',
            start: new Date(date.getFullYear(), date.getMonth() + 1, -13),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -12),
            extendedProps: {
                calendar: 'Family'
            }
        },
        {
            id: 8,
            url: '',
            title: 'Product Review',
            start: new Date(date.getFullYear(), date.getMonth() + 1, -13),
            end: new Date(date.getFullYear(), date.getMonth() + 1, -12),
            allDay: true,
            extendedProps: {
                calendar: 'Business'
            }
        },
        {
            id: 9,
            url: '',
            title: 'Monthly Meeting',
            start: nextMonth,
            end: nextMonth,
            allDay: true,
            extendedProps: {
                calendar: 'Business'
            }
        },
        {
            id: 10,
            url: '',
            title: 'Monthly Checkup',
            start: prevMonth,
            end: prevMonth,
            allDay: true,
            extendedProps: {
                calendar: 'Personal'
            }
        }
    ];


    (function () {
        var calendarEl = document.getElementById('calendar'),
            appCalendarSidebar = document.querySelector('.app-calendar-sidebar'),
            addEventSidebar = document.getElementById('addEventSidebar'),
            appOverlay = document.querySelector('.app-overlay'),
            calendarsColor = {
                Business: 'primary',
                Holiday: 'success',
                Personal: 'danger',
                Family: 'warning',
                ETC: 'info'
            },
            eventTitle = document.querySelector('#eventTitle'),
            eventStartDate = document.querySelector('#eventStartDate'),
            eventEndDate = document.querySelector('#eventEndDate'),
            eventUrl = document.querySelector('#eventURL'),
            eventLabel = $('#eventLabel'), // ! Using jquery vars due to select2 jQuery dependency
            eventGuests = $('#eventGuests'), // ! Using jquery vars due to select2 jQuery dependency
            eventLocation = document.querySelector('#eventLocation'),
            eventDescription = document.querySelector('#eventDescription'),
            allDaySwitch = document.querySelector('.allDay-switch'),
            selectAll = document.querySelector('.select-all'),
            filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
            inlineCalendar = document.querySelector('.inline-calendar');

        var eventToUpdate,
            currentEvents =
            events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calender events
            isFormValid = false,
            inlineCalInstance;

        //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
        // Event Label (select2)
        if (eventLabel.length) {
            function renderBadges(option) {
                if (!option.id) {
                    return option.text;
                }
                var $badge =
                    "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " + '</span>' +
                    option.text;

                return $badge;
            }
            eventLabel.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Select value',
                dropdownParent: eventLabel.parent(),
                templateResult: renderBadges,
                templateSelection: renderBadges,
                minimumResultsForSearch: -1,
                escapeMarkup: function (es) {
                    return es;
                }
            });
        }

        // Event Guests (select2)
        if (eventGuests.length) {
            function renderGuestAvatar(option) {
                if (!option.id) {
                    return option.text;
                }
                var $avatar =
                    "<div class='d-flex flex-wrap align-items-center'>" +
                    "<div class='avatar avatar-xs me-2'>" +
                    "<img src='" +
                    assetsPath +
                    'img/avatars/' +
                    $(option.element).data('avatar') +
                    "' alt='avatar' class='rounded-circle' />" +
                    '</div>' +
                    option.text +
                    '</div>';

                return $avatar;
            }
            eventGuests.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Select value',
                dropdownParent: eventGuests.parent(),
                closeOnSelect: false,
                templateResult: renderGuestAvatar,
                templateSelection: renderGuestAvatar,
                escapeMarkup: function (es) {
                    return es;
                }
            });
        }

        // Event start (flatpicker)
        if (eventStartDate) {
            var start = eventStartDate.flatpickr({
                enabvarime: true,
                altFormat: 'Y-m-dTH:i:S',
                onReady: function (selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        instance.mobileInput.setAttribute('step', null);
                    }
                }
            });
        }

        // Event end (flatpicker)
        if (eventEndDate) {
            var end = eventEndDate.flatpickr({
                enabvarime: true,
                altFormat: 'Y-m-dTH:i:S',
                onReady: function (selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        instance.mobileInput.setAttribute('step', null);
                    }
                }
            });
        }

        // Inline sidebar calendar (flatpicker)
        if (inlineCalendar) {
            inlineCalInstance = inlineCalendar.flatpickr({
                monthSelectorType: 'static',
                inline: true
            });
        }

        // Event click function
        function eventClick(info) {
            alert(info.event.title);
        }

        // Modify sidebar toggler
        function modifyToggler() {
            var fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
            fcSidebarToggleButton.classList.remove('fc-button-primary');
            fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
            while (fcSidebarToggleButton.firstChild) {
                fcSidebarToggleButton.firstChild.remove();
            }
            fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
            fcSidebarToggleButton.setAttribute('data-overlay', '');
            fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar');
            fcSidebarToggleButton.insertAdjacentHTML('beforeend',
                '<i class="mdi mdi-menu mdi-24px text-body"></i>');
        }

        // Filter events by calender
        function selectedCalendars() {
            var selected = [],
                filterInputChecked = [].slice.call(document.querySelectorAll('.input-filter:checked'));

            filterInputChecked.forEach(item => {
                selected.push(item.getAttribute('data-value'));
            });

            return selected;
        }

        // --------------------------------------------------------------------------------------------------
        // AXIOS: fetchEvents
        // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
        // --------------------------------------------------------------------------------------------------
        function fetchEvents(info, successCallback) {
            // Fetch Events from API endpoint reference
            /* $.ajax(
              {
                url: '../../../app-assets/data/app-calendar-events.js',
                type: 'GET',
                success: function (result) {
                  // Get requested calendars as Array
                  var calendars = selectedCalendars();

                  return [result.events.filter(event => calendars.includes(event.extendedProps.calendar))];
                },
                error: function (error) {
                  console.log(error);
                }
              }
            ); */

            var calendars = selectedCalendars();
            // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
            // You should make an API call, look into above commented API call for reference
            var selectedEvents = currentEvents.filter(function (event) {
                // console.log(event.extendedProps.calendar.toLowerCase());
                return calendars.includes(event.extendedProps.calendar.toLowerCase());
            });
            // if (selectedEvents.length > 0) {
            successCallback(selectedEvents);
            // }
        }

        // Init FullCalendar
        // ------------------------------------------------
        var direction = 'ltr';

        if (isRtl) {
            direction = 'rtl';
        }
        var calendar = new Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: fetchEvents,
            plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
            editable: true,
            dragScroll: true,
            dayMaxEvents: 2,
            eventResizableFromStart: true,
            customButtons: {
                sidebarToggle: {
                    text: 'Sidebar'
                }
            },
            headerToolbar: {
                start: 'sidebarToggle, prev,next, title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            direction: direction,
            initialDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            eventClassNames: function ({
                event: calendarEvent
            }) {
                var colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                // Background Color
                return ['fc-event-' + colorName];
            },
            dateClick: function (info) {
                var date = moment(info.date).format('YYYY-MM-DD');
                resetValues();
                bsAddEventSidebar.show();

                btnSubmit.innerHTML = 'Add';
                btnSubmit.classList.remove('btn-update-event');
                btnSubmit.classList.add('btn-add-event');
                btnDevareEvent.classList.add('d-none');
                eventStartDate.value = date;
                eventEndDate.value = date;
            },
            eventClick: function (info) {
                eventClick(info);
            },
            datesSet: function () {
                modifyToggler();
            },
            viewDidMount: function () {
                modifyToggler();
            }
        });

        // Render calendar
        calendar.render();
        // Modify sidebar toggler
        modifyToggler();

        // Reset event form inputs values
        // ------------------------------------------------
        function resetValues() {
            eventEndDate.value = '';
            eventUrl.value = '';
            eventStartDate.value = '';
            eventTitle.value = '';
            eventLocation.value = '';
            allDaySwitch.checked = false;
            eventGuests.val('').trigger('change');
            eventDescription.value = '';
        }

        // Calender filter functionality
        // ------------------------------------------------
        if (selectAll) {
            selectAll.addEventListener('click', e => {
                if (e.currentTarget.checked) {
                    document.querySelectorAll('.input-filter').forEach(c => (c.checked = 1));
                } else {
                    document.querySelectorAll('.input-filter').forEach(c => (c.checked = 0));
                }
                calendar.refetchEvents();
            });
        }

        if (filterInput) {
            filterInput.forEach(item => {
                item.addEventListener('click', () => {
                    document.querySelectorAll('.input-filter:checked').length < document
                        .querySelectorAll('.input-filter').length ?
                        (selectAll.checked = false) :
                        (selectAll.checked = true);
                    calendar.refetchEvents();
                });
            });
        }

        // Jump to date on sidebar(inline) calendar change
        inlineCalInstance.config.onChange.push(function (date) {
            calendar.changeView(calendar.view.type, moment(date[0]).format('YYYY-MM-DD'));
            modifyToggler();
            appCalendarSidebar.classList.remove('show');
            appOverlay.classList.remove('show');
        });
    })();
</script>