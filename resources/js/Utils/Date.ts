import { format, intervalToDuration, isValid, parseISO } from 'date-fns'
import { toZonedTime } from 'date-fns-tz'

interface DecomposeDateFormat {
  year: string;
  month: string;
  day: string;
  weekday: string;
  hour: string;
  minute: string;
  second: string;
}

// ブラウザのタイムゾーンで日時を変換する関数
export function parseToBrowserTz(dateISOString: string): Date {
  if (!isValid(parseISO(dateISOString))) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }
  const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone
  const date = new Date(dateISOString)
  return toZonedTime(date, userTimeZone)
}

// ブラウザのタイムゾーンで日時を変換する関数
export function formattedToBrowserTz(dateISOString: string, formatStr: string = 'yyyy-MM-dd HH:mm:ss'): string {
  if (!isValid(parseISO(dateISOString))) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }

  const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone
  const date = new Date(dateISOString)
  const zonedDate = toZonedTime(date, userTimeZone)

  return format(zonedDate, formatStr, { timeZone: userTimeZone })
}

// 二つの日付から詳細な期間を求める関数
export function getDurationBetweenDates(startDateISOString: string, endDateISOString: string): Duration {
  if (!startDateISOString || !endDateISOString) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }

  const startDate = parseISO(startDateISOString)
  const endDate = parseISO(endDateISOString)

  if (!startDate || !endDate || isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }

  return intervalToDuration({ start: startDate, end: endDate })
}

// 日付を分解して詳細情報を返す関数
export function decomposeDate(dateISOString: string, formatStr: DecomposeDateFormat = { year: 'yyyy', month: 'MM', day: 'dd', weekday: 'E', hour: 'HH', minute: 'mm', second: 'ss' }): DecomposeDateFormat {
  if (!dateISOString) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }
  const date = parseISO(dateISOString)

  if (!date || isNaN(date.getTime())) {
    throw new Error('Invalid date input: 無効な日付形式です。ISO 8601形式の日付文字列を指定してください。')
  }

  return {
    year: format(date, formatStr.year),
    month: format(date, formatStr.month),
    day: format(date, formatStr.day),
    weekday: format(date, formatStr.weekday),
    hour: format(date, 'HH'),
    minute: format(date, 'mm'),
    second: format(date, 'ss'),
  }
}
