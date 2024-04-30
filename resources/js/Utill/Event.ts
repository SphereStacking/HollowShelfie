import { getDurationBetweenDates, formattedToBrowserTz } from '@/Utill/Date'

export function getEventPeriod(startDate: string, endDate: string) {
  if (!startDate || !endDate) {
    console.error('Invalid date input:', { startDate, endDate })
    return ''
  }
  const duration = getDurationBetweenDates(startDate, endDate)
  if (!duration) {
    return ''
  }
  let durationString = ''

  // duration オブジェクトのキーをチェックして、存在するものだけ文字列に追加
  if (duration.hours) durationString += duration.hours + 'h '
  if (duration.minutes) durationString += duration.minutes + 'm '
  if (duration.seconds) durationString += duration.seconds + 's '

  // 末尾の空白を削除し、必要に応じて ' - ' を追加
  durationString = durationString.trim()
  if (durationString) {
    durationString = ' - ' + durationString
  }

  return formattedToBrowserTz(startDate) + durationString
}
