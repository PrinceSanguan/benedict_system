<script>
  var date = new Date();
  var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;

  var containerEl = document.getElementById('external-events');
  var checkbox = document.getElementById('drop-remove');
  var calendarEl = document.getElementById('calendar');

  var eventsData = [
      @if($events->isNotEmpty())
        @foreach($events as $event)
        {
            id: {{$event->id}},
            title: '{{$event->title}}',
            date:'{{$event->date}}',
            information: '{{$event->information}}',
            photo: '{{$event->photo}}',
            attachment: '{{$event->attachment}}',
        },
        @endforeach
      @endif
  ];

  var calendarEvents = eventsData.map(function(event) {
      return {
          id: event.id,
          title: event.title,
          start: event.date, 
          extendedProps: {
              information: event.information,
              photo: event.photo,
              attachment: event.attachment,
              user_id: event.user_id,
              created_at: event.created_at,
              updated_at: event.updated_at
          }
      };
  });

  var calendar = new Calendar(calendarEl, {
      headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      events: calendarEvents,
      editable: false,
      droppable: true,
      drop: function(info) {
          if (checkbox.checked) {
              info.draggedEl.parentNode.removeChild(info.draggedEl);
          }
      },
      eventClick: function(info) {
          Swal.fire({
              title: info.event.title,
              html: `
                  <div>
                        <p><strong>Date:</strong> ${info.event.start.toLocaleDateString()}</p>
                        <img src="/storage/${info.event.extendedProps.photo}" alt="${info.event.title}" style="width: 100%; max-width: 300px;" />
                        <p><strong>Attachment:</strong> <a href="/storage/${info.event.extendedProps.attachment}" target="_blank">Download</a></p>
                        <p>${info.event.extendedProps.information}</p>
                    </div>
              `,
              showCloseButton: true,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonText: 'Close'
          });
      }
  });

  calendar.render();
</script>
