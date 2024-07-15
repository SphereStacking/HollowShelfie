import { format } from 'date-fns'

// 共通の型定義
interface CalendarEvent {
  title: string;
  dates: string[];
  description: string;
  location: string;
  links: { label: string; url: string }[];
}

// タイプで指定されたcalendarへの登録を行う
export function createCalendarEvent(
  type: string = 'Google',
  event: CalendarEvent
): string | void {
  switch (type.toLowerCase()) {
  case 'google':
    return createGoogleCalendarUrl(event)
  case 'outlook':
    return createMicrosoftCalendarUrl(event)
  case 'icalendar':
    return createICalendarFile(event)
  default:
    throw new Error('Invalid calendar type')
  }
}

function formatDate(date: string, isAllDay: boolean = false): string {
  return isAllDay ? format(new Date(date), 'yyyyMMdd') : format(new Date(date), 'yyyyMMdd\'T\'HHmmss\'Z\'')
}

function createGoogleCalendarUrl(event: CalendarEvent): string {
  const { title, dates = [], description, location, links = [] } = event
  const base = 'https://www.google.com/calendar/render?action=TEMPLATE'
  const _title = `&text=${encodeURIComponent(title)}`

  // リンクをHTML形式でエンコード
  const formattedLinks = links.map(link => `<a href="${link.url}">${link.label}</a>`).join('<br>')
  const _description = `&details=${encodeURIComponent(formattedLinks + '<br><br>' +description)}`
  const _location = `&location=${encodeURIComponent(location)}`

  let dateParam = ''
  if (dates.length === 1) {
    // 終日イベント
    dateParam = `&dates=${formatDate(dates[0], true)}/${formatDate(dates[0], true)}`
  } else if (dates.length === 2) {
    // 期間イベント
    dateParam = `&dates=${formatDate(dates[0])}/${formatDate(dates[1])}`
  }
  console.log(dateParam)
  return `${base}${_title}${dateParam}${_description}${_location}`
}

// MicrosoftカレンダーのURLを生成
function createMicrosoftCalendarUrl(event: CalendarEvent): string {
  const { title, dates = [], description, location, links = [] } = event
  const base = 'https://outlook.live.com/calendar/0/deeplink/compose?path=%2fcalendar%2faction%3dcompose&rru=addevent'
  const subject = `&subject=${encodeURIComponent(title)}`
  const _location = `&location=${encodeURIComponent(location)}`

  // リンクをテキスト形式でエンコード
  const formattedLinks = links.map(link => `${link.label}: ${link.url}`).join('\n')
  const body = `&body=${encodeURIComponent(description + '\n' + formattedLinks)}`

  let dateParams = ''
  if (dates.length === 1) {
    // 終日イベント
    dateParams = `&startdt=${dates[0]}&enddt=${dates[0]}`
  } else if (dates.length === 2) {
    // 期間イベント
    dateParams = `&startdt=${dates[0]}&enddt=${dates[1]}`
  }

  return `${base}${subject}${_location}${body}${dateParams}`
}

// マック用のcalendar登録
function createICalendarFile(event) {
  const { title, dates = [], description, location, links = [] } = event

  // iCalendar フォーマットの基本的な構造を設定
  let icsData = 'BEGIN:VCALENDAR\n'
  icsData += 'VERSION:2.0\n'
  icsData += 'BEGIN:VEVENT\n'

  // イベントの詳細を設定
  icsData += `SUMMARY:${title}\n`
  icsData += `DESCRIPTION:${description}\n`
  icsData += `LOCATION:${location}\n`
  icsData += `URL:${links.map(link => link.url).join(',')}\n`

  if (dates.length === 1) {
    // 終日イベント
    icsData += `DTSTART;VALUE=DATE:${formatDate(dates[0], true)}\n`
    icsData += `DTEND;VALUE=DATE:${formatDate(dates[0], true)}\n`
  } else if (dates.length === 2) {
    // 期間イベント
    icsData += `DTSTART:${formatDate(dates[0])}\n`
    icsData += `DTEND:${formatDate(dates[1])}\n`
  }

  // iCalendar フォーマットの終了
  icsData += 'END:VEVENT\n'
  icsData += 'END:VCALENDAR\n'

  // Blob オブジェクトを作成
  const blob = new Blob([icsData], { type: 'text/calendar' })

  // Blob オブジェクトからダウンロードリンクを作成
  const url = window.URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.style.display = 'none'
  a.href = url
  a.setAttribute('download', title + '.ics')

  // ダウンロードリンクを DOM に追加してクリックイベントを発火
  document.body.appendChild(a)
  a.click()

  // ダウンロードリンクを DOM から削除
  document.body.removeChild(a)

  // Blob URLを解放
  window.URL.revokeObjectURL(url)
}
