export type JourneyMode = "social" | "experience" | "professional";

export type Journey = {
  id: string;
  title: string;
  route: string[];
  startDate: string;
  startDateIso: string;
  endDate: string;
  organizer: string;
  amountMinor: number;
  currency: "EUR";
  placesLeft: number;
  mode: JourneyMode;
  tags: string[];
  accessible: boolean;
  cover: string;
  coverAlt: string;
  description: string;
};
