
//タイプで指定されたcalendarへの登録を行う
export function createCalendarEvent(type='Google',title,dates,details,location){
  switch (type.toLowerCase()) {
    case 'google':
      return createGoogleCalendarUrl(title, dates, details, location);
    case 'outlook':
      return createMicrosoftCalendarUrl(title, dates, details, location);
    // case 'icalendar':
    //   return createICalendarFile(title, dates, details, location);
    default:
      throw new Error('Invalid calendar type');
  }
}

//グーグルcalendarに予定を追加する。
//datesが一つしか入っていない場合は終日イベントとなる
// createGoogleCalendarUrl('Meeting', ['20231025T090000', '20231025T100000'], 'Business meeting', 'Conference Room');
function createGoogleCalendarUrl(title,dates,details,location) {
  const URL=[];
  const base = 'https://www.google.com/calendar/render?action=TEMPLATE';
  const _title = `&text=${encodeURIComponent(title)}`;
  const _details = `&details=${encodeURIComponent(details)}`;
  const _location = `&location=${encodeURIComponent(location)}`;
  console.log(`${base}${_title}${_details}${_location}`);

  if (dates.size=1) {
    //終日イベント
    const date = `&date=${dates[0]}`;
    return `${base}${_title}${date}${_details}${_location}`;

  } else {
    //期間イベント
    const dates = `&dates=${dates[0]}/${dates[1]}`;
    console.log(`${base}${_title}${dates}${_details}${_location}`);
    return `${base}${_title}${dates}${_details}${_location}`;
  }
}

// MicrosoftカレンダーのURLを生成
// createMicrosoftCalendarUrl('Meeting', ['20231025T090000', '20231025T100000'], 'Business meeting', 'Conference Room');
function createMicrosoftCalendarUrl(title,dates,details,location) {
  const base = 'https://outlook.live.com/calendar/0/deeplink/compose?path=%2fcalendar%2faction%3dcompose&rru=addevent';
  const subject = `&subject=${encodeURIComponent(title)}`;
  const _location = `&location=${encodeURIComponent(location)}`;
  const body = `&body=${encodeURIComponent(details)}`;

  if (dates.length=1) {
    //終日イベント
    const startdt = `&startdt=${dates[0]}`;
    const enddt = `&enddt=${dates[0]}`;
    return `${base}${subject}${_location}${body}${startdt}${enddt}`;

  } else {
    //期間イベント
    const startdt = `&startdt=${dates[0]}`;
    const enddt = `&enddt=${dates[1]}`;
    return `${base}${subject}${_location}${body}${startdt}${enddt}`;
  }
}

//マック用のcalendar登録
// 使用例
// createICalendarFile('Meeting', ['20231025T090000', '20231025T100000'], 'Business meeting', 'Conference Room');
function createICalendarFile(title, dates, details, location) {
  // iCalendar フォーマットの基本的な構造を設定
  let icsData = 'BEGIN:VCALENDAR\n';
  icsData += 'VERSION:2.0\n';
  icsData += 'PRODID:-//Your Company//Your Product//EN\n';
  icsData += 'BEGIN:VEVENT\n';

  // イベントの詳細を設定
  icsData += `SUMMARY:${title}\n`;
  icsData += `DESCRIPTION:${details}\n`;
  icsData += `LOCATION:${location}\n`;

  if (dates.length === 1) {
    // 終日イベント
    icsData += `DTSTART;VALUE=DATE:${dates[0]}\n`;
    icsData += `DTEND;VALUE=DATE:${dates[0]}\n`;
  } else {
    // 期間イベント
    icsData += `DTSTART:${dates[0]}\n`;
    icsData += `DTEND:${dates[1]}\n`;
  }

  // iCalendar フォーマットの終了
  icsData += 'END:VEVENT\n';
  icsData += 'END:VCALENDAR\n';

  // Blob オブジェクトを作成
  const blob = new Blob([icsData], { type: 'text/calendar' });

  // Blob オブジェクトからダウンロードリンクを作成
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.style.display = 'none';
  a.href = url;
  a.download = 'event.ics';

  // ダウンロードリンクを DOM に追加してクリックイベントを発火
  document.body.appendChild(a);
  a.click();

  // ダウンロードリンクを DOM から削除
  document.body.removeChild(a);
}

