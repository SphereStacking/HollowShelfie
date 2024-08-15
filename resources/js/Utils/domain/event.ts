
import { decomposeDate, getDurationBetweenDates } from '@/Utils/Date'

export const _formattedStartDate = (startDate: string) => {
  if (!startDate) {
    return { weekday: '', hour: '', minute: '', second: '' }
  }
  return decomposeDate(startDate)
}

export const _eventPeriod = (startDate: string, endDate: string) => {
  if (!startDate || !endDate) {
    return '日時が入力されていません'
  }
  const formattedStartDate = decomposeDate(startDate)
  let durationString = ''
  const duration = getDurationBetweenDates(startDate, endDate)
  // duration オブジェクトのキーをチェックして、存在するものだけ文字列に追加
  if (duration.hours) durationString += duration.hours + 'h '
  if (duration.minutes) durationString += duration.minutes + 'm '
  if (duration.seconds) durationString += duration.seconds + 's '

  // 末尾の空白を削除し、必要に応じて ' - ' を追加
  durationString = durationString.trim()
  if (durationString) {
    durationString = ' - ' + durationString
  }
  return `${formattedStartDate.year}/${formattedStartDate.month}/${formattedStartDate.day} [${formattedStartDate.weekday}] ${formattedStartDate.hour}:${formattedStartDate.minute} ${durationString}`
}

type EventShareTextProps = {
  title: string
  period: string
  platformNames: string[]
  instanceNames: string[]
  organizerNames: string[]
  performerNames: string[]
  categoryNames: string[]
  tags: string[]
  url: string
}

export const generateEventAdminShareText = (props: EventShareTextProps) => {
  const appName = import.meta.env.VITE_APP_NAME || 'HollowShelfie'
  const formattedCategories = props.categoryNames.map(category =>
    category.startsWith('#') ? category : `#${category}`
  ).join(' ')
  const formattedTags = props.tags.map(tag =>
    tag.startsWith('#') ? tag : `#${tag}`
  ).join(' ')
  const platformNames = props.platformNames.map(platform =>
    platform.startsWith('#') ? platform : `#${platform}`
  ).join(' ')
  return '🎉 新しいイベントが公開されました！ 🎉\n' +
   '\n' +
   `✨ ${props.title}\n` +
   `📅 ${props.period}\n` +
   `🌐 ${platformNames}\n` +
   `📍 ${props.instanceNames.join(' ')}\n` +
   `👥 ${props.organizerNames.join(' ')}\n` +
   `🎤 ${props.performerNames.join(' ')}\n` +
   `🎨 ${formattedCategories}\n` +
   `🏷 ${formattedTags}\n` +
   '\n' +
   '詳細は 👻#' + appName + ' で！ 👇\n' +
   `${props.url}`
}

export const generateEventOrganizerShareText = (props: EventShareTextProps) => {
  const appName = import.meta.env.VITE_APP_NAME || 'HollowShelfie'
  const formattedCategories = props.categoryNames.map(category =>
    category.startsWith('#') ? category : `#${category}`
  ).join(' ')
  const formattedTags = props.tags.map(tag =>
    tag.startsWith('#') ? tag : `#${tag}`
  ).join(' ')
  const platformNames = props.platformNames.map(platform =>
    platform.startsWith('#') ? platform : `#${platform}`
  ).join(' ')
  return `🎉イベントを開催します！ 🎉\n` +
   '\n' +
   `✨ ${props.title}\n` +
   `📅 ${props.period}\n` +
   `🌐 ${platformNames}\n` +
   `📍 ${props.instanceNames.join(' ')}\n` +
   `👥 ${props.organizerNames.join(' ')}\n` +
   `🎤 ${props.performerNames.join(' ')}\n` +
   `🎨 ${formattedCategories}\n` +
   `🏷 ${formattedTags}\n` +
   '\n' +
   '詳細は 👻#' + appName + ' で！ 👇\n' +
   `${props.url}`
}

export const generateEventParticipantShareText = (props: EventShareTextProps) => {
  const appName = import.meta.env.VITE_APP_NAME || 'HollowShelfie'
  const formattedCategories = props.categoryNames.map(category =>
    category.startsWith('#') ? category : `#${category}`
  ).join(' ')
  const formattedTags = props.tags.map(tag =>
    tag.startsWith('#') ? tag : `#${tag}`
  ).join(' ')
  const platformNames = props.platformNames.map(platform =>
    platform.startsWith('#') ? platform : `#${platform}`
  ).join(' ')
  return `${props.title}  に参加します！\n` +
   '一緒に参加しませんか？\n' +
   '\n' +
   `📅 ${props.period}\n` +
   `🌐 ${platformNames}\n` +
   `🎨 ${formattedCategories}\n` +
   `🏷 ${formattedTags}\n` +
   '\n' +
   '詳細は 👻#' + appName + ' で！ 👇\n' +
   `${props.url}`
}
