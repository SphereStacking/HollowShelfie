import { startOfMonth, endOfMonth, eachDayOfInterval, format, addDays, subDays } from 'date-fns'

// カレンダーの日付を生成する関数
export function generateCalendarDates(year, month) {
  // 月の初日と最終日を取得
  const firstDay = startOfMonth(new Date(year, month - 1))
  const lastDay = endOfMonth(new Date(year, month - 1))

  // 前月と次月の日付も含めてリストを生成
  const startDay = subDays(firstDay, firstDay.getDay())
  const endDay = addDays(lastDay, 6 - lastDay.getDay())

  const days = eachDayOfInterval({ start: startDay, end: endDay }).map(day => {
    const isCurrentMonth = day.getMonth() + 1 === month
    const isToday = format(day, 'yyyy-MM-dd') === format(new Date(), 'yyyy-MM-dd')

    return {
      date: format(day, 'yyyy-MM-dd'),
      isCurrentMonth,
      isToday,
    }
  })

  return days
}

