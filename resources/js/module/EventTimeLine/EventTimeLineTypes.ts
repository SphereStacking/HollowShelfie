export type Organizer = {
  id: number,
  image_url: string,
  profile_url: string,
};
export type Performer = {
  id: number,
  name: string,
  image_url: string,
  profile_url: string,
};

export type TimeTable = {
  id: number,
  performers: Performer[],
  start_time: string,
  end_time: string,
};

export type TimeLineItem = {
  alias: string,
  shortGoodCount: string,
  startDate: string,
  endDate: string,
  title: string,
  period: string,
  instances: string[],
  organizers: Organizer[],
  performers: Performer[],
  timeTable: TimeTable[],
  categoryNames: string[],
  tags: string[],
  route: string,

  authUser: {
    isGood: boolean,
    isBookmark: boolean,
  },
};
