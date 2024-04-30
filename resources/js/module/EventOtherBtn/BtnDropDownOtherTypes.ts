export type Good = {
  isGood: boolean,
  goodCount: string|null,
}

export type Bookmark = {
  isBookmark: boolean,
}

export type SnsShare = {
  title: string,
  period: string,
  instances: string[],
  organizers: string[],
  performers: string[],
  categoryNames: string[],
  tags: string[],
  route: string,
}
